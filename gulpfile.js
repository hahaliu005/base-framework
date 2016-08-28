const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

var fs = require('fs');
var ini = require('ini');
var config = ini.parse(fs.readFileSync('./common.ini', 'utf-8'), true);
var service = config.base.service;

elixir(function (mix) {
    var lessDir = './resources/' + service + '/assets/less/';
    var files = fs.readdirSync(lessDir);
    for (var i = 0; i < files.length; i++) {
        mix.less(lessDir + files[i], './public/css/' + files[i].replace(/less$/, 'css'))
    }
});



//elixir(function (mix) {
//    mix.webpack('**/*.js')
//})
