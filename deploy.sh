#!/bin/bash

# サーバ情報（自分の環境に合わせて変えてね）
SERVER_USER="ubuntu"
SERVER_HOST="133.125.36.207"
REMOTE_PATH="/var/www/Laravel_hiroyuki"

echo "==== rsyncでコードをサーバに転送 ===="
rsync -avz \
  --exclude ".env" \
  --exclude "vendor/" \
  --exclude "node_modules/" \
  --exclude "storage/" \
  ./ ${SERVER_USER}@${SERVER_HOST}:${REMOTE_PATH}/

echo "==== サーバにSSH接続してセットアップ実行 ===="
ssh ${SERVER_USER}@${SERVER_HOST} << EOF
  cd ${REMOTE_PATH}
  composer install --no-dev
  sudo chown -R ubuntu:www-data ${REMOTE_PATH}
  sudo chmod -R 775 storage bootstrap/cache
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  php artisan migrate --force
EOF

echo "==== デプロイ完了 ===="
