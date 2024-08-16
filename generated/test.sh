#!/bin/bash

# 現在のディレクトリを取得
BASE_DIR=$(pwd)

# プロトファイルのディレクトリに移動
cd /workspaces/Nicolive-API/src/proto

# 全ての.protoファイルを再帰的に検索し、相対パスでprotocコマンドを実行
find . -name "*.proto" | while read -r proto_file; do
  protoc --php_out="$BASE_DIR/generated" "$proto_file"
done

# 元のディレクトリに戻る
cd $BASE_DIR
