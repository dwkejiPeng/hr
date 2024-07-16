# HR 管理系统

HR 管理系统是一个简单的在线招聘和人才管理系统，支持用户和企业的注册、登录、职位发布、职位申请和信息管理等功能。

## 项目结构
/ (项目根目录)
├── api/
│ ├── db.php
├── css/
│ ├── styles.css
├── js/
│ ├── scripts.js
├── admin/
│ ├── dashboard.php
│ ├── candidates.php
│ ├── jobs.php
│ ├── companies.php
│ ├── settings.php
├── user/
│ ├── user_register.php
│ ├── user_login.php
│ ├── user_profile.php
│ ├── my_applications.php
├── company/
│ ├── company_register.php
│ ├── company_login.php
│ ├── company_profile.php
│ ├── company_dashboard.php
│ ├── add_job.php
│ ├── company_applications.php
├── public/
│ ├── index.php
│ ├── apply_job.php
├── logout.php
├── .htaccess
├── config.php


## 功能概述

### 用户功能

- 用户注册：用户可以创建一个新账户。
- 用户登录：用户可以登录到系统。
- 更新求职信息：用户可以更新个人信息。
- 查看我的投递：用户可以查看自己申请的职位。

### 企业功能

- 企业注册：企业可以创建一个新账户。
- 企业登录：企业可以登录到系统。
- 更新企业信息：企业可以更新公司信息（仅首次注册时）。
- 企业管理：企业可以发布职位、查看申请该职位的用户信息。

### 通用功能

- 公开招聘信息：所有用户可以查看公开的招聘信息。
- 申请职位：注册用户可以申请职位。

## 安装步骤

### 1. 克隆代码库

```bash
git clone https://github.com/dwkejipeng/hr.git
cd hr-management-system

### 2. 配置数据库
创建一个新的MySQL数据库，并执行以下SQL语句以创建所需的表：

CREATE DATABASE hr_dwkeji;
USE hr_dwkeji;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    gender VARCHAR(10),
    birthday DATE,
    education VARCHAR(255),
    graduation_school VARCHAR(255),
    major VARCHAR(255),
    title VARCHAR(255),
    phone VARCHAR(20),
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE companies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    name VARCHAR(255),
    description TEXT,
    company_type VARCHAR(255),
    company_size VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    salary VARCHAR(255),
    experience VARCHAR(255),
    education VARCHAR(255),
    job_type VARCHAR(255),
    job_address VARCHAR(255),
    company_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id) ON DELETE CASCADE
);

CREATE TABLE applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_id INT NOT NULL,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    resume TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (job_id) REFERENCES jobs(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

###3. 配置项目

<?php
class Database {
    private $host = "localhost";
    private $db_name = "hr_dwkeji";
    private $username = "hr_dwkeji";
    private $password = "Davidgzs228919";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>

4. 配置Web服务器
确保您的Web服务器（如Apache）配置正确，以支持PHP和URL重写。您可以使用项目根目录中的 .htaccess 文件来配置URL重写。

5. 运行项目
将项目文件部署到您的Web服务器根目录，然后在浏览器中访问：

http://yourdomain.com/public/index.php

##使用说明
###用户注册和登录
用户可以通过点击右上角的“登录”按钮，选择“用户登录”或“用户注册”来创建账户或登录系统。
登录后，用户可以更新个人信息或查看已投递的职位。
###企业注册和登录
企业可以通过点击右上角的“登录”按钮，选择“企业登录”或“企业注册”来创建账户或登录系统。
登录后，企业可以发布新职位、查看投递信息，或更新企业信息。
###查看和申请职位
所有用户都可以在公开招聘信息页面查看职位列表。
注册用户可以点击“申请职位”按钮来申请职位。
###贡献
欢迎贡献代码和提交问题。请遵循以下步骤贡献代码：

Fork 本项目。
创建您的功能分支 (git checkout -b feature/your-feature)。
提交您的更改 (git commit -am 'Add some feature')。
推送到分支 (git push origin feature/your-feature)。
创建一个新的 Pull Request。
许可证
此项目采用 MIT 许可证开源。详情请参阅 LICENSE 文件。


这个 README 文件包括了项目的结构、功能、安装步骤和使用说明，帮助开发者和用户快速上手项目。如果您有任何具体的需求或更改，请告诉我。
