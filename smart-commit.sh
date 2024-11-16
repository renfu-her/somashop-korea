#!/bin/bash

# 顏色定義
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

# 獲取變更檔案列表
changed_files=$(git status --porcelain)

if [ -z "$changed_files" ]; then
    echo -e "${YELLOW}沒有需要提交的更改${NC}"
    exit 0
fi

commit_message=""

# 檢查是否有配置檔案更改
if echo "$changed_files" | grep -q "config\|.env\|.yml\|.json"; then
    commit_message+="📦 配置: 更新配置檔案\n"
fi

# 檢查是否有資料庫遷移檔案
if echo "$changed_files" | grep -q "database/migrations"; then
    commit_message+="🗃️ 遷移: 更新遷移檔案\n"
fi

# 檢查是否有依賴更新
if echo "$changed_files" | grep -q "composer.json\|package.json\|yarn.lock\|composer.lock"; then
    commit_message+="📚 依賴: 更新專案依賴\n"
fi

# 檢查是否有文件更新
if echo "$changed_files" | grep -q "README\|docs/\|.md"; then
    commit_message+="📝 文件: 更新文件\n"
fi

# 檢查是否有測試檔案更新
if echo "$changed_files" | grep -q "tests/\|.test.\|.spec."; then
    commit_message+="🧪 測試: 更新測試用例\n"
fi

# 檢查是否有樣式檔案更新
if echo "$changed_files" | grep -q ".css\|.scss\|.less\|.style"; then
    commit_message+="💄 樣式: 更新介面樣式\n"
fi

# 檢查是否有控制器更新
if echo "$changed_files" | grep -q "app/Http/Controllers"; then
    commit_message+="🎮 Controller 控制器: 更新控制器邏輯\n"
fi

# 檢查是否有模型更新
if echo "$changed_files" | grep -q "app/Models"; then
    commit_message+="📊 Model 模型: 更新資料模型\n"
fi

# 檢查是否有視圖檔案更新
if echo "$changed_files" | grep -q "resources/views"; then
    commit_message+="🎨 View 視圖: 更新頁面模板\n"
fi

# 如果沒有匹配到特定類型，則添加預設訊息
if [ -z "$commit_message" ]; then
    commit_message="🔨 更新: 程式碼優化與更新"
fi

# 顯示變更檔案
echo -e "${BLUE}變更檔案列表:${NC}"
echo "$changed_files"
echo -e "\n${BLUE}提交訊息:${NC}"
echo -e "$commit_message"

# 詢問是否繼續
read -p "是否繼續提交? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    # 執行 git 命令
    git add .
    git commit -m "$commit_message"
    
    # 詢問是否推送
    read -p "是否推送到遠端儲存庫? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git push
        echo -e "${GREEN}已成功推送到遠端儲存庫${NC}"
    fi
else
    echo -e "${YELLOW}取消提交${NC}"
fi 