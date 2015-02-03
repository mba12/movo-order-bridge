module.exports = {
    "Test admin page on localhost": function (test) {
        test.open("http://movo.app:8000/admin")
            .wait(2000)
            .assert.text('#login .inner h3', 'Log in to the admin section')
            .type('input[name="name"]', 'admin')
            .type('input[name="password"]', 'HrKwO4ApDutpwSLzMY7A')
            .click('input[type="submit"]')
            .wait(2000)
            .assert.text('.period', 'last hour')
            .screenshot('tests/admin.png')
            .wait(2000)
            .click('a[href="/admin/logout"]')
            .done();
    } ,
    "Test admin on remote site": function (test) {
        test.open("https://orders.getmovo.com/admin")
            .wait(2000)
            .assert.text('#login .inner h3', 'Log in to the admin section')
            .type('input[name="name"]', 'admin')
            .type('input[name="password"]', 'HrKwO4ApDutpwSLzMY7A')
            .screenshot('tests/admin-filled-out.png')
            .click('input[type="submit"]')
            .wait(2000)
            .assert.text('.period', 'last hour')
            .screenshot('tests/admin-logged-in.png')
            .click('a[href="/admin/logout"]')
            .wait(2000)
            .screenshot('tests/admin-logged-out.png')
            .done();
    }
}
