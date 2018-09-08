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

host('staging')
    ->hostname('icanhazstring.net')
    ->user('icanhazsting')
    ->identityFile('/home/vagrant/.ssh/icanhazstring_id_rsa')
    ->forwardAgent(true)
    ->port(41022)
    ->stage('maintenance')
    ->set('environment', 'staging')
    ->set('link_target', 'staging')
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
    ->set('deploy_path', '/var/www/{{application}}');
    
// Tasks
task('deploy:symlink', function () {
    if (get('use_atomic_symlink')) {
        run("mv -T {{deploy_path}}/release {{deploy_path}}/{{link_target}}");
    } else {
        // Atomic symlink does not supported.
        // Will use simple≤ two steps switch.

        run("cd {{deploy_path}} && {{bin/symlink}} {{release_path}} {{link_target}}"); // Atomic override symlink.
        run("cd {{deploy_path}} && rm release"); // Remove release link.
    }
});

task('deploy:nginx-setup', function() {
    run('sudo ln -sf {{deploy_path}}/{{link_target}}/config/nginx.{{environment}}.conf /etc/nginx/sites-enabled/issues.icanhazstring.net');
//    run('sudo certbot -d issues.icanhazstring.net -n --nginx');
    run('sudo systemctl reload nginx');
});

after('deploy:unlock', 'deploy:nginx-setup');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

