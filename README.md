# docker-development

## Overview

vscodeのDevContainers拡張機能を利用したコンテナ内開発ができます。  
以下の環境が構築できます。  
・nginx:latest  
・php:8.2-fpm  
・mariadb  
・sql server 

## Requirement
・dockerが動く環境  
・vscode 拡張機能でDevContainersを入れる  

## ローカルのWindowsPCで動かす場合
・dockerを準備  
・git clone https://github.com/iida5/development.git  
・developmentディレクトリをvscodeで開く  
・右下の Reopen in Container をクリック 

## リモートのLinuxサーバーで動かす場合  
・サーバーを準備してdockerを入れる  
・vscodeでサーバーにSSH接続  
  yum install git docker  
  sudo pip3 install docker-compose  
  sudo groupadd docker  
  sudo usermod -aG docker $USER  
  newgrp docker  
・git clone https://github.com/iida5/development.git  
・cd development  
・右下の Reopen in Container をクリック  

## DevContainersの使い方

コンテナに入る  
・vscode 右下の Reopen in Container をクリック  
もしくは vscode左下の><をクリックし Reopen in Container をクリック  

コンテナから切断  
・vscode左下の><をクリックし、Reopen Folder Localy  

## Usage  
コンテナを開くと次のフォルダが表示されます。  
・web → ユーザー画面用サーバー  
・api → api用サーバー  
・admin → 管理画面用サーバー  
・tool → 開発ツール等を置く用  

コンテナのファイルは次のURLで表示できます。  
linuxの場合はlocalhostをipに置きかえてください。  
・web/public → http://localhost:8081/  
・api/public → http://localhost:8082/  
・admin/public → http://localhost:8083/  
・tool/public → http://localhost:8080/  

## ドメイン名(https)でのアクセス  
・docker-composeのreverse-proxyを有効化  
・DNS設定後reverse-proxyコンテナに入って下記を実行  

apt update  
apt install certbot python3-certbot-nginx  
certbot --nginx certonly -d web.ドメイン --register-unsafely-without-email --agree-tos -n  
certbot --nginx certonly -d api.ドメイン --register-unsafely-without-email --agree-tos -n  
certbot --nginx certonly -d admin.ドメイン --register-unsafely-without-email --agree-tos -n  
  
各webサーバーのnginx設定を変更の上再起動  

