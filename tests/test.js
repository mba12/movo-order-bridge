module.exports = {
    "Test Movo order totals": function (test) {
        /*test.open("http://movo.app:8000")
            .screenshot("movo.png")
            .assert.exists('#products .next', "Next button exists on products page")
            .screenshot("form.png")
            .click('#products .next')
            .assert.visible('.error-messages li')
            .screenshot("form2.png")
            .click('#unit1 option[value="857458005008"]')
            .click('#products .next')
            .waitForElement("#billing-info h3")
            .screenshot("form3.png")
            .assert.not.visible('.error-messages li')
            .done();*/
        test.open("http://movo.app:8000")
            .click('#unit1 option[value="857458005008"]')
            .click('#products .next')
            .type('#loop1', '1')
            .click('#loops .next')
            .type('#billing-first-name', 'Ryan')
            .type('#billing-last-name', 'Hovland')
            .type('#billing-phone', '503-555-5555')
            .type('#email', 'ryan@jumpkick.pro')
            .type('#billing-address', '1651 Ash St')
            .type('#billing-city', 'Lake Oswego')
            .click('#billing-state-select option[value="OR"]')
            .type('#billing-zip', '97034')
            .click('#billing-info .next')

            // testing New York sales tax
            .type('#shipping-first-name', 'Ryan')
            .type('#shipping-last-name', 'Hovland')
            .type('#shipping-phone', '503-555-5555')
            .type('#shipping-address', '1651 Ash St')
            .type('#shipping-city', 'Lake Oswego')
            .click('#shipping-state-select option[value="NY"]')
            .type('#shipping-zip', '10007')
            .click('#shipping-type option[value="1"]')
            .click('#shipping-info .next')
            .wait(2000)
            .assert.text('#total .price li', '$49.80')

            // testing Oregon sales tax
            .click('#payment .prev')
            .type('#shipping-zip', '97034')
            .click('#shipping-state-select option[value="OR"]')
            .click('#shipping-info .next')
            .wait(2000)
            .assert.text('#total .price li', '$45.74')


            .click('#cc-month option[value="12"]')
            .type('#cvc', '123')
            .type('#coupon-code', 'friends20')
            .click('#submit-coupon-code')
            .wait(2000)
            .assert.text('#total .price li', '$39.74')

            .click('#submit-order')
            .wait(3000)
            .assert.visible('#summary')

            .screenshot('test.png')
            .done();
    }
}