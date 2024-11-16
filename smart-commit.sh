#!/bin/bash

# 颜色定义
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m'

# 获取变更文件列表
changed_files=$(git status --porcelain)

if [ -z "$changed_files" ]; then
    echo -e "${YELLOW}没有需要提交的更改${NC}"
    exit 0
fi

commit_message=""

# 检查是否有配置文件更改
if echo "$changed_files" | grep -q "config\|.env\|.yml\|.json"; then
    commit_message+="📦 配置: 更新配置文件\n"
fi

# 检查是否有数据库迁移文件
if echo "$changed_files" | grep -q "database/migrations"; then
    commit_message+="🗃️ 数据库: 更新迁移文件\n"
fi

# 检查是否有依赖更新
if echo "$changed_files" | grep -q "composer.json\|package.json\|yarn.lock\|composer.lock"; then
    commit_message+="📚 依赖: 更新项目依赖\n"
fi

# 检查是否有文档更新
if echo "$changed_files" | grep -q "README\|docs/\|.md"; then
    commit_message+="📝 文档: 更新文档\n"
fi

# 检查是否有测试文件更新
if echo "$changed_files" | grep -q "tests/\|.test.\|.spec."; then
    commit_message+="🧪 测试: 更新测试用例\n"
fi

# 检查是否有样式文件更新
if echo "$changed_files" | grep -q ".css\|.scss\|.less\|.style"; then
    commit_message+="💄 样式: 更新界面样式\n"
fi

# 检查是否有控制器更新
if echo "$changed_files" | grep -q "app/Http/Controllers"; then
    commit_message+="🎮 控制器: 更新控制器逻辑\n"
fi

# 检查是否有模型更新
if echo "$changed_files" | grep -q "app/Models"; then
    commit_message+="📊 模型: 更新数据模型\n"
fi

# 检查是否有视图文件更新
if echo "$changed_files" | grep -q "resources/views"; then
    commit_message+="🎨 视图: 更新页面模板\n"
fi

# 如果没有匹配到特定类型，则添加默认消息
if [ -z "$commit_message" ]; then
    commit_message="🔨 更新: 代码优化与更新"
fi

# 显示变更文件
echo -e "${BLUE}变更文件列表:${NC}"
echo "$changed_files"
echo -e "\n${BLUE}提交信息:${NC}"
echo -e "$commit_message"

# 询问是否继续
read -p "是否继续提交? (y/n) " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    # 执行 git 命令
    git add .
    git commit -m "$commit_message"
    
    # 询问是否推送
    read -p "是否推送到远程仓库? (y/n) " -n 1 -r
    echo
    if [[ $REPLY =~ ^[Yy]$ ]]; then
        git push
        echo -e "${GREEN}已成功推送到远程仓库${NC}"
    fi
else
    echo -e "${YELLOW}取消提交${NC}"
fi 