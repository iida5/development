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

## AWS上で動かす場合

AWS上での作業  

AWSにログイン  

AmazonLightsailに移動  

インスタンスの作成  

プラットフォームの選択 Linux  

設計図の選択 OSのみ Ubunt 22.04LTSを選択  

オプション  

SSHキーペアの変更  

新規作成（既存のカギでも可）  
キー名はdeveloment適当に  
キーをダウンロードして下記に保存  
C:\Users\ユーザー名\.ssh\development.pem  

インスタスプランの選択 $10 (2GB MEM)  

インスタンスを確認  
他の人と区別がつくようにインスタ名を付ける  
例) ubuntu-development-yourname  

インスタンスの作成をクリック  

作成されたインスタンスのGlobalIPをメモする  
例）35.72.8.192  

ネットワーキングタブをクリック  
ルールを追加  
カスタム TCP 8080-8083 で作成  

VSCODEを開く  

左メニューのリモートエクスプローラーを開く  
リモートを選択  
SSH右側の歯車マークをクリック  
c:\Users\Work\.ssh\config を選択  

configに下記を張り付けて保存  

Host AWS開発  
  HostName 先ほどメモしたip  
  User ubuntu  
  IdentityFile ~/.ssh/development.pem  

リモート右側のリロードマーククリック  
AWS開発の→(現在のウィンドウで接続)をクリック  

接続が成功すると続行の選択が出るのでクリック  

ファイル一覧を開く  

フォルダーを開くをクリック  
/home/ubuntu/  
でOK  
作者を信頼するをクリック  

ターミナルを開く　下記コマンドを実行 1行ずつ実行 Y/n は全部Y   
sudo apt update  
sudo apt -y install ca-certificates curl gnupg lsb-release  
sudo mkdir -p /etc/apt/keyrings  
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo gpg --dearmor -o /etc/apt/keyrings/docker.gpg  
echo "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.gpg] https://download.docker.com/linux/ubuntu $(lsb_release -cs)   stable" | sudo tee /etc/apt/sources.list.d/docker.list  
sudo apt update  
sudo apt -y install docker-ce docker-ce-cli containerd.io docker-compose-plugin  
sudo usermod -aG docker $USER  
sudo systemctl enable docker  
sudo systemctl is-enabled docker  

git clone https://github.com/iida5/development.git  

vscodeのリモートエクスプローラーからAWS開発に再接続  
ファイル一覧を開く  
フォルダーを開くをクリック  
/home/ubuntu/development  
でOk   

vscode右下に Reopen in Container が表示されるのでクリック  

インストールが始まります  

インストール後下記にアクセスしてphpinfが表示されれば成功  
http://メモしたip:8080/info.php  
