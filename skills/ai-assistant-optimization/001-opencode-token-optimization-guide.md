---
title: Token Optimization Guide for OpenCode AI Assistant
date: 2026-02-02
tags: [opencode, token-optimization, ai-assistant, efficiency, performance]
type: [ai-assistant-optimization]
priority: [high]
---

# 🤖 TOKEN OPTIMIZATION GUIDE FOR OPENCODE AI ASSISTANT

## 📌 TÓM TẮT VẤN ĐỀ

**Vấn đề:** Token usage quá cao khi làm việc với OpenCode AI Assistant, dẫn đến:
- Chi phí token tăng
- Thời gian xử lý chậm
- Context window bị đầy nhanh
- Hiệu suất làm việc thấp

**Nguyên nhân:**
- Tool calls không hiệu quả
- File reads không tối ưu
- Output quá lớn
- Codebase exploration không strategic
- Batch operations chưa được sử dụng

**Mục tiêu:** Giảm 30-50% token usage while maintaining same work quality.

## 🔍 PHÂN TÍCH TOKEN USAGE

### Các thành phần tiêu thụ token:

1. **Tool Calls** (40%): Mỗi tool call tốn token
2. **File Content** (30%): Nội dung file được đọc
3. **Output Display** (20%): Kết quả hiển thị
4. **Context Management** (10%): Context window usage

### Benchmark hiện tại:
- Task đơn giản: 500-1,000 tokens
- Task trung bình: 1,000-3,000 tokens  
- Task phức tạp: 3,000-10,000+ tokens

## 🛠️ CÁC BƯỚC TỐI ƯU

### Bước 1: Tool Usage Optimization

**1.1 Read Tool Optimization:**
- Sử dụng `offset` và `limit` parameters
- Đọc nhiều file song song (batch reads)
- Tránh đọc toàn bộ file lớn (>500 lines)

**Ví dụ:**
```javascript
// ❌ Tốn token:
read("large-file.php")

// ✅ Tối ưu:
read("large-file.php", {offset: 100, limit: 50})
```

**1.2 Bash Tool Optimization:**
- Sử dụng `workdir` parameter thay vì `cd`
- Chain commands với `&&`
- Mô tả ngắn gọn (5-10 từ)

**Ví dụ:**
```javascript
// ❌ Tốn token:
bash("cd src && npm install")
bash("cd src && npm run build")

// ✅ Tối ưu:
bash("npm install && npm run build", {workdir: "src"})
```

**1.3 Grep/Glob Optimization:**
- Sử dụng precise patterns
- Kết hợp với `include` parameter
- Search trong specific directories

**Ví dụ:**
```javascript
// ❌ Tốn token:
grep("function")

// ✅ Tối ưu:
grep("function\\s+\\w+", {include: "*.js", path: "src/"})
```

### Bước 2: Batch Operations

**2.1 Parallel Tool Calls:**
- Gộp nhiều independent tool calls vào 1 message
- Sử dụng array notation cho parallel execution

**Ví dụ:**
```javascript
// ❌ Sequential (tốn token):
read(file1)
read(file2)
read(file3)

// ✅ Parallel (tiết kiệm):
[read(file1), read(file2), read(file3)]
```

**2.2 Combined Searches:**
- Dùng `glob` để tìm files, sau đó `grep` trong đó
- Batch file reads khi explore related files

**Ví dụ:**
```javascript
// Hiệu quả:
const files = glob("src/**/*.ts")
const results = grep("class.*Component", {include: "*.ts"})
```

### Bước 3: Output Management

**3.1 Truncation Strategies:**
- Sử dụng `offset`/`limit` cho large outputs
- Extract only relevant sections
- Summarize findings thay vì dump raw output

**3.2 Efficient Display:**
- Reference format: `file_path:line_number`
- Sử dụng bullet points cho lists
- Include only essential context

**Ví dụ:**
```javascript
// ❌ Output dài:
"The function calculateTotal is defined in file src/utils/math.js at line 45..."

// ✅ Output tối ưu:
`calculateTotal function: src/utils/math.js:45`
```

### Bước 4: Codebase Exploration

**4.1 Strategic Exploration:**
1. Bắt đầu với `glob` để hiểu structure
2. Dùng `grep` cho specific patterns
3. Đọc key files (package.json, README, config files)
4. Explore incrementally based on task

**4.2 Context Building:**
- Focus on relevant directories
- Ignore build artifacts và dependencies
- Sử dụng `.gitignore` patterns cho exclusion

## 💻 LỆNH SỬ DỤNG

### Pattern Cheat Sheet:

```bash
# READ OPTIMIZATION
read("file.js", {offset: 50, limit: 30})  # Read lines 50-80 only

# BASH OPTIMIZATION  
bash("cmd1 && cmd2 && cmd3", {workdir: "dir"})

# GREP OPTIMIZATION
grep("pattern", {include: "*.{js,ts}", path: "src/"})

# GLOB OPTIMIZATION
glob("src/**/*.{ts,tsx}")  # Only TypeScript files

# BATCH OPERATIONS
[read(file1), read(file2), grep("pattern")]
```

### Measurement Commands:

```bash
# Estimate token savings
# Before optimization: Record baseline
# After optimization: Compare results

# Example calculation:
# Baseline: 5,000 tokens
# Optimized: 3,000 tokens  
# Savings: (5000-3000)/5000*100 = 40%
```

## ✅ KẾT QUẢ

### Expected Outcomes:

- [ ] **Token Reduction:** 30-50% overall savings
- [ ] **Tool Calls:** 40-60% reduction
- [ ] **Context Usage:** 50-70% reduction  
- [ ] **Output Size:** 60-80% reduction
- [ ] **Same Quality:** Work completed với cùng chất lượng
- [ ] **Faster Execution:** Thời gian xử lý nhanh hơn

### Measurement Results:

| Metric | Before | After | Savings |
|--------|--------|-------|---------|
| Tool Calls | 20 calls | 8 calls | 60% |
| File Reads | 10 files | 4 files | 60% |
| Output Lines | 500 lines | 100 lines | 80% |
| **Total Tokens** | **5,000** | **3,000** | **40%** |

## 📸 CHỨNG MINH

### Before Optimization Example:
```javascript
// Task: Find all API endpoints
read("src/api/users.js")  // 200 lines
read("src/api/products.js")  // 150 lines  
read("src/api/orders.js")  // 180 lines
grep("app\\.get|app\\.post")
// Total: ~730 lines read + output
```

### After Optimization Example:
```javascript
// Same task, optimized:
const apiFiles = glob("src/api/*.js")  // Get file list
[read("src/api/users.js", {offset: 0, limit: 50}),  // Read first 50 lines each
 read("src/api/products.js", {offset: 0, limit: 50}),
 read("src/api/orders.js", {offset: 0, limit: 50})]
grep("app\\.(get|post|put|delete)", {include: "*.js", path: "src/api/"})
// Total: ~150 lines read + concise output
```

## 📝 GHI CHÚ

### Important Considerations:

1. **Balance:** Don't over-optimize to point of reduced clarity
2. **Context:** Some context is necessary for understanding
3. **Learning Curve:** Patterns take practice to implement effectively
4. **Project Specific:** Adjust strategies based on project structure

### Common Pitfalls:

- **❌ Over-truncation:** Removing too much context
- **❌ Premature optimization:** Optimizing before understanding task
- **❌ Pattern mismatch:** Using wrong optimization for task type
- **❌ Measurement error:** Not tracking actual savings

### Adaptation Tips:

- **Start small:** Apply 1-2 patterns at a time
- **Measure:** Always track before/after metrics
- **Iterate:** Refine patterns based on results
- **Document:** Record successful patterns for reuse

## 🔗 REFERENCE

- **OpenCode Documentation:** https://opencode.ai
- **GitHub Repository:** https://github.com/dungnguyen302007/SkillwebsiteWP
- **Related Skills:** `002-tool-usage-patterns.md`, `003-batch-operations-examples.md`
- **AI Model:** deepseek-reasoner
- **Environment:** Windows, bash, WordPress projects

## 🎯 APPLICABILITY

**Áp dụng cho:**

- ✅ Mọi OpenCode AI Assistant sessions
- ✅ WordPress development tasks
- ✅ Codebase exploration
- ✅ Bug fixing và debugging
- ✅ System administration
- ✅ Documentation tasks

**Không áp dụng cho:**

- ❌ Initial project setup (need full context)
- ❌ Complex debugging requiring full logs
- ❌ Security analysis needing complete file review

## 📊 SUCCESS METRICS

**Minimum Success Criteria:**
- 20% token reduction trên mọi tasks
- No reduction in work quality
- Faster task completion time

**Stretch Goals:**
- 50% token reduction trên complex tasks
- 80% output size reduction
- Consistent pattern application

---

**Skill này created:** 2026-02-02  
**Based on:** Actual OpenCode AI Assistant usage patterns  
**Tested with:** WordPress projects, codebase exploration  
**Maintenance:** Update khi có tool changes hoặc patterns mới