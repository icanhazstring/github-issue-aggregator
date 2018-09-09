<?php
namespace Deployer;

require 'recipe/zend_framework.php';

// Project name
set('application', 'GithubIssueAggregator');

// Project repository
set('repository', 'https://github.com/icanhazstring/github-issue-aggregator.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

set('http_user', 'www-data');
set('http_group', 'www-data');

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', ['data']);

// Hosts
host('maintenance')
    ->hostname('icanhazstring.net')
    ->user('icanhazstring')
    ->identityFile('/home/vagrant/.ssh/icanhazstring_id_rsa')
    ->forwardAgent(true)
    ->port(41022)
    ->stage('maintenance')
    ->set('environment', 'maintenance')
    ->set('link_target', 'maintenance')
    ->set('deploy_path', '/var/www/{{application}}');

host('production')
    ->hostname('icanhazstring.net')
    ->user('icanhazstring')
    ->identityFile('/home/vagrant/.ssh/icanhazstring_id_rsa')
    ->forwardAgent(true)
    ->port(41022)
    ->stage('production')
    ->set('environment', 'production')
    ->set('link_target', 'current')
    ->set('GITHUB_CLIENT_ID' , function() {
        return getenv('GITHUB_CLIENT_ID');
    })
    ->set('GITHUB_CLIENT_SECRET' , function() {
        return getenv('GITHUB_CLIENT_SECRET');
    })
    ->set('deploy_path', '/var/www/{{application}}');
    
// Tasks
task('deploy:symlink', function () {
    if (get('use_atomic_symlink')) {
        run("mv -T {{deploy_path}}/release {{deploy_path}}/{{link_target}}");
    } else {
        run("cd {{deploy_path}} && {{bin/symlink}} {{release_path}} {{link_target}}");
        run("cd {{deploy_path}} && rm release");
    }
});

task('deploy:link-site', function() {
    run('sudo ln -sf {{deploy_path}}/{{link_target}}/config/nginx.{{environment}}.conf /etc/nginx/sites-enabled/issues.icanhazstring.net');
})->onStage('production');

task('deploy:prepare-nginx', function() {
    // Copy github conf and fill with credentials
    run('cp {{deploy_path}}/{{link_target}}/config/github.conf.dist {{deploy_path}}/{{link_target}}/config/github.conf');

    $clientId = run('echo $GITHUB_CLIENT_ID');
    $clientSecret = run('echo $GITHUB_CLIENT_SECRET');

    run("sed -i 's/<id>/" . $clientId . "/g' {{deploy_path}}/{{link_target}}/config/github.conf");
    run("sed -i 's/<secret>/" . $clientSecret . "/g' {{deploy_path}}/{{link_target}}/config/github.conf");

//    run('sudo certbot -d issues.icanhazstring.net -n --nginx');
});

task('deploy:reload-nginx', function() {
    run('sudo systemctl reload nginx');
});

after('deploy:symlink', 'deploy:link-site');
after('deploy:link-site', 'deploy:prepare-nginx');
after('deploy:prepare-nginx', 'deploy:reload-nginx');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

