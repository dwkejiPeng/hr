数据结构：

Users (用户表)
id (INT, AUTO_INCREMENT, PRIMARY KEY) - 用户ID
username (VARCHAR(255), NOT NULL) - 用户名
password (VARCHAR(255), NOT NULL) - 密码（哈希值）
name (VARCHAR(255)) - 姓名
gender (VARCHAR(10)) - 性别
birthday (DATE) - 生日
education (VARCHAR(255)) - 学历
graduation_school (VARCHAR(255)) - 毕业学校
major (VARCHAR(255)) - 专业
title (VARCHAR(255)) - 职称
phone (VARCHAR(20)) - 手机号
email (VARCHAR(255)) - 邮箱
created_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP) - 创建时间
updated_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) - 更新时间

Companies (企业表)
id (INT, AUTO_INCREMENT, PRIMARY KEY) - 企业ID
username (VARCHAR(255), NOT NULL) - 用户名
password (VARCHAR(255), NOT NULL) - 密码（哈希值）
name (VARCHAR(255)) - 企业名称
description (TEXT) - 描述
company_type (VARCHAR(255)) - 公司性质
company_size (VARCHAR(255)) - 公司规模
created_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP) - 创建时间
updated_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) - 更新时间

Jobs (职位表)
id (INT, AUTO_INCREMENT, PRIMARY KEY) - 职位ID
title (VARCHAR(255), NOT NULL) - 职位名称
salary (VARCHAR(255)) - 薪酬
experience (VARCHAR(255)) - 工作经验
education (VARCHAR(255)) - 学历
job_type (VARCHAR(255)) - 工作性质
job_address (VARCHAR(255)) - 工作地址
company_id (INT, NOT NULL) - 企业ID（外键，关联companies表）
created_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP) - 创建时间
updated_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP) - 更新时间

Applications (投递表)
id (INT, AUTO_INCREMENT, PRIMARY KEY) - 投递ID
job_id (INT, NOT NULL) - 职位ID（外键，关联jobs表）
user_id (INT, NOT NULL) - 用户ID（外键，关联users表）
name (VARCHAR(255), NOT NULL) - 用户姓名
email (VARCHAR(255), NOT NULL) - 用户邮箱
phone (VARCHAR(20), NOT NULL) - 用户手机号
resume (TEXT, NOT NULL) - 用户简历
created_at (TIMESTAMP, DEFAULT CURRENT_TIMESTAMP) - 创建时间


数据库结构（SQL 语句）

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

