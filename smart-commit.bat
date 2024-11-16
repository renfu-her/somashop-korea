@echo off
setlocal EnableDelayedExpansion

:: 设置控制台颜色代码
set "GREEN=[32m"
set "YELLOW=[33m"
set "BLUE=[34m"
set "RED=[31m"
set "NC=[0m"

:: 检查是否有变更
git status --porcelain > temp.txt
set /p changed_files=<temp.txt
if "!changed_files!"=="" (
    echo %YELLOW%没有需要提交的更改%NC%
    del temp.txt
    exit /b
)

:: 初始化提交信息
set "commit_message="

:: 检查配置文件
findstr /i "config .env .yml .json" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!📦 配置: 更新配置文件\n"
)

:: 检查数据库迁移
findstr /i "database/migrations" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!🗃️ 数据库: 更新迁移文件\n"
)

:: 检查依赖更新
findstr /i "composer.json package.json yarn.lock composer.lock" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!📚 依赖: 更新项目依赖\n"
)

:: 检查文档更新
findstr /i "README docs/ .md" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!📝 文档: 更新文档\n"
)

:: 检查测试文件
findstr /i "tests/ .test. .spec." temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!🧪 测试: 更新测试用例\n"
)

:: 检查样式文件
findstr /i ".css .scss .less .style" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!💄 样式: 更新界面样式\n"
)

:: 检查控制器
findstr /i "app/Http/Controllers" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!🎮 控制器: 更新控制器逻辑\n"
)

:: 检查模型
findstr /i "app/Models" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!📊 模型: 更新数据模型\n"
)

:: 检查视图文件
findstr /i "resources/views" temp.txt >nul
if not errorlevel 1 (
    set "commit_message=!commit_message!🎨 视图: 更新页面模板\n"
)

:: 如果没有匹配到特定类型，使用默认消息
if "!commit_message!"=="" (
    set "commit_message=🔨 更新: 代码优化与更新"
)

:: 显示变更文件
echo %BLUE%变更文件列表:%NC%
type temp.txt
echo.
echo %BLUE%提交信息:%NC%
echo !commit_message!

:: 删除临时文件
del temp.txt

:: Ask for confirmation
set /p confirm=Continue with commit? (y/n): 
if /i "!confirm!"=="y" (
    :: Execute git commands
    git add .
    git commit -m "!commit_message!"
    
    :: Ask about pushing
    set /p push=Push to remote repository? (y/n): 
    if /i "!push!"=="y" (
        git push
        echo %GREEN%Successfully pushed to remote repository%NC%
    )
) else (
    echo %YELLOW%Commit cancelled%NC%
)

endlocal 