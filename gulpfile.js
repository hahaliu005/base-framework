const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

var fs = require('fs');
var ini = require('ini');
var config = ini.parse(fs.readFileSync('./common.ini', 'utf-8'), true);
var service = config.base.service;

elixir(function (mix) {
    // copy 第三方库
    mix.copy('./node_modules/jquery/dist/jquery.min.js', 'public/js/');
    mix.copy('./node_modules/bootstrap/dist/js/bootstrap.min.js', 'public/js/');
    mix.copy('./node_modules/bootstrap/dist/css/bootstrap.min.css', 'public/css/');
    mix.copy('./node_modules/bootstrap/dist/fonts', 'public/fonts'),
    mix.copy('./node_modules/bootstrap/dist/css/bootstrap-theme.min.css', 'public/css/');

    mix.copy('./resources/libs/plupload', 'public/plupload');
});

elixir(function (mix) {
    var lessDir = './resources/' + service + '/assets/less/';
    var files = fs.readdirSync(lessDir);
    var versionFiles = [];
    for (var i = 0; i < files.length; i++) {
        var from = lessDir + files[i];
        var target = './public/css/' + files[i].replace(/less$/, 'css');
        mix.less(from, target);
        versionFiles.push(target);
    }
    mix.version(versionFiles);
});

//elixir(function (mix) {
//    mix.webpack('**/*.js')
//})
