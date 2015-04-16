 class RemoteForm {


        public $form:JQuery;

        constructor(public tag:string, public successCallback:any, public errorCallback:any) {
            this.findForm(tag);
            this.addSubmitClickHandler();
        }

        private addSubmitClickHandler():void{
            if(this.$form.length==0) return;
            this.$form.on("submit", (e)=> {
                var method:string = this.$form.find('input[name="_method"]').val() || "POST";
                var url = this.$form.prop("action");
                $.ajax({
                    type: method,
                    url: url,
                    data: this.$form.serialize(),
                    success:(result)=>{
                         this.successCallback(result);
                    },
                    error:(result)=>{
                        this.errorCallback(result);
                    }
                });
                e.preventDefault();
            })
        }

        private findForm(tag:string):void {
            this.$form=$(tag);
        }

}



