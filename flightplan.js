var plan = require('flightplan');


plan.target('homestead', {
    host: '192.168.10.10:2222',
    port:'2222',
    username: 'vagrant',
    agent: process.env.SSH_AUTH_SOCK
});

plan.local(function(local) {
     /*local.with("cd C:\\Users\\Alex\\Documents\\Work\\Homestead", function(){
       local.exec("ls")
       local.exec("vagrant ssh");
       local.exec("php artisan migrate");
       local.exec("exit");
     })*/
});



// run commands on the target's remote hosts
plan.remote(function(remote) {
    console.log(plan.runtime.target);  // 'production'
    remote.log('list files on staging');
    remote.with("cd Code/movo/bridge", function(){
        remote.exec("ls");
        //remote.exec("git pull origin master")
    })
});


