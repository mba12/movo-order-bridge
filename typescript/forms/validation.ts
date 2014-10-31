/*
 Example usage:
 data-error-selector=".error-messages .month"
 <input type="text" name="month" placeholder="01" maxlength="2" data-validate="number|minValue:1|maxValue:12" />

 this.$submitBtn.on('click', ()=> {
     var validation:Validation = new Validation($('[data-validate]', "#age-gate"));
     if (validation.isValidForm()) {
         validation.resetErrors();
         this.submitForm();
     } else {
        validation.showErrors();
     }
 });

 */

class Validation {
    errors:FormError[];

    constructor(public $formInputs:JQuery) {

    }

    public isValidForm():boolean {
        this.errors = [];
        var isValid:boolean = true;
        this.$formInputs.each((i, val)=> {
            var $input:JQuery = $(val);
            if (!this.isValidInput($input)) {
                isValid = false;
                this.errors.push(new FormError($input));
            }
        });
        return isValid;
    }

    public resetErrors():void {
        this.$formInputs.each((i, val)=> {
            var $input:JQuery = $(val);
            this.hideInputErrors($input);
        })
    }

    public showErrors():void {
        this.resetErrors();
        for (var i = 0; i < this.errors.length; i++) {
            this.displayInputErrors(this.errors[i].input);
        }
    }

    private hideInputErrors($el:JQuery):void {
        if ($el.data("input-selector")) {
            $($el.data("input-selector")).removeClass("error");
        } else {
            $el.removeClass("error");
        }
        if ($el.data("error-selector")) {
            $($el.data("error-selector")).hide();
        }
    }

    private displayInputErrors($el:JQuery):void {
        if ($el.data("input-selector")) {
            var is:JQuery=  $($el.data("input-selector"));
            $($el.data("input-selector")).addClass("error");
        } else {
            $el.addClass("error");
        }

        if ($el.data("error-selector")) {
            $($el.data("error-selector")).show();
            if ($el.data("error-message")) {
                $($el.data("error-selector")).html($el.data("error-message"));
            }
        }
    }

    private isValidInput($el:JQuery):boolean {
        try {
            if (!$el.data("validate")) {
                return true;
            }
            ;
            /*if (this.fieldContainsPlaceholderText($el)) {
             return false;
             }*/
            var isValid:boolean = true;
            var value:string = $el.val();
            var data = $el.data("validate");
            var validators:string[] = this.extractValidatorStrings(data);

            for (var i = 0; i < validators.length; i++) {
                var validator:string = validators[i];
                if (!this.isValidEmail(value, validator)) {
                    isValid = false
                }
                if (!this.isMinimumLength(value, validator)) {
                    isValid = false
                }
                if (!this.isMaximumLength(value, validator)) {
                    isValid = false
                }
                if (!this.isMatch(value, validator)) {
                    isValid = false
                }
                if (!this.isChecked($el, validator)) {
                    isValid = false
                }
                if (!this.isNumber(value, validator)) {
                    isValid = false;
                }
                if (!this.isMinValue(value, validator)) {
                    isValid = false;
                }
                if (!this.isMaxValue(value, validator)) {
                    isValid = false;
                }
            }

            return isValid;

        } catch (e) {
            return false;
        }
    }

    private extractValidatorStrings(data:string):string[] {
        return data.split("|");
    }

    private fieldContainsPlaceholderText(input:JQuery):boolean {
        return input.val() == input.attr("placeholder");
    }

    private  isValidEmail(email:string, validator:string):boolean {
        if (validator != "email") return true;
        var regex = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return regex.test(email);
    }

    private isMinimumLength(value:string, validator:string):boolean {
        if (validator.indexOf("min:") == -1) return true;
        var minimum:number = <any>validator.split(":")[1];
        return value.length >= minimum;
    }

    private isMaximumLength(value:string, validator:string):boolean {
        if (validator.indexOf("max:") == -1) return true;
        var maximum:number = <any>validator.split(":")[1];
        return value.length <= maximum;
    }

    private isMatch(value:string, validator:string):boolean {
        if (validator.indexOf("matches:") == -1) return true;
        var selector:string = <any>validator.split(":")[1];
        return value == $(selector).val();
    }

    private isChecked($el:JQuery, validator:string):boolean {
        if (validator.indexOf("checked") == -1) return true;
        return $el.is(":checked");
    }

    private isNumber(value:any, validator:string):boolean {
        if (validator != "number") return true;
        return !isNaN(value);
    }

    private isMinValue(value:any, validator:string):boolean {
        if (validator.indexOf("minValue:") == -1) return true;
        var minimum:number = <any>validator.split(":")[1];
        return !isNaN(parseInt(value)) && parseInt(value) >= minimum;
    }

    private isMaxValue(value:any, validator:string):boolean {
        if (validator.indexOf("maxValue:") == -1) return true;
        var maximum:number = <any>validator.split(":")[1];
        return !isNaN(parseInt(value)) && parseInt(value) <= maximum;
    }
}