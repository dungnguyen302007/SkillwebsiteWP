---
title: Tool Usage Patterns for OpenCode AI Assistant
date: 2026-02-02
tags: [opencode, tools, patterns, optimization, efficiency]
type: [ai-assistant-optimization]
priority: [high]
---

# 🛠️ TOOL USAGE PATTERNS FOR OPENCODE AI ASSISTANT

## 📌 TÓM TẮT

**Mục tiêu:** Cung cấp patterns cụ thể cho từng tool để tối ưu token usage.

**Các tools covered:**
1. **Read Tool** - File reading optimization
2. **Bash Tool** - Command execution optimization  
3. **Grep Tool** - Content search optimization
4. **Glob Tool** - File pattern search optimization
5. **Task Tool** - Delegation optimization
6. **Edit/Write Tools** - File modification optimization

## 🔧 READ TOOL PATTERNS

### Pattern 1: Offset/Limit Parameters

**Vấn đề:** Đọc toàn bộ file lớn tốn nhiều token.

**Solution:** Sử dụng `offset` và `limit` để đọc chỉ phần cần thiết.

**Ví dụ:**
```javascript
// ❌ Inefficient:
read("large-file.php")  // Reads all 1000+ lines

// ✅ Optimized:
read("large-file.php", {offset: 100, limit: 50})  // Reads lines 100-150 only
```

**Use Cases:**
- Config files: Đọc phần cấu hình cụ thể
- Log files: Đọc recent entries
- Source code: Đọc specific function definitions

### Pattern 2: Batch File Reads

**Vấn đề:** Multiple sequential reads tốn nhiều tool calls.

**Solution:** Batch multiple reads in parallel.

**Ví dụ:**
```javascript
// ❌ Sequential:
read("file1.js")
read("file2.js") 
read("file3.js")

// ✅ Parallel batch:
[read("file1.js"), read("file2.js"), read("file3.js")]
```

**Best Practices:**
- Batch related files (e.g., all files in same directory)
- Limit batch size to 3-5 files
- Use khi files độc lập với nhau

### Pattern 3: Selective Reading

**Vấn đề:** Đọc file không cần thiết.

**Solution:** Chỉ đọc khi thực sự cần.

**Strategy:**
1. Dùng `glob` để list files
2. Dùng `grep` để tìm relevant sections
3. Chỉ `read` files có chứa cần tìm

**Ví dụ:**
```javascript
// Efficient workflow:
const configFiles = glob("**/*config*.{js,json}")
const hasDbConfig = grep("DB_|database", {include: "*.js"})
// Chỉ đọc files có database config
```

## 🖥️ BASH TOOL PATTERNS

### Pattern 1: Workdir Parameter

**Vấn đề:** Sử dụng `cd` commands tạo ra multiple bash calls.

**Solution:** Sử dụng `workdir` parameter.

**Ví dụ:**
```javascript
// ❌ Inefficient:
bash("cd src && npm install")
bash("cd src && npm run build")

// ✅ Optimized:
bash("npm install && npm run build", {workdir: "src"})
```

### Pattern 2: Command Chaining

**Vấn đề:** Multiple commands executed separately.

**Solution:** Chain commands với `&&` hoặc `;`.

**Ví dụ:**
```javascript
// ❌ Multiple calls:
bash("git status")
bash("git add .")
bash("git commit -m 'update'")

// ✅ Single call:
bash("git status && git add . && git commit -m 'update'")
```

**Chaining Operators:**
- `&&`: Run next command only if previous succeeds
- `;`: Run next command regardless
- `||`: Run next command only if previous fails
- `|`: Pipe output between commands

### Pattern 3: Output Management

**Vấn đề:** Bash output quá lớn.

**Solution:** Use output filtering và truncation.

**Ví dụ:**
```javascript
// ❌ Large output:
bash("find . -type f -name '*.js'")

// ✅ Filtered output:
bash("find . -type f -name '*.js' | head -20")
```

**Output Control Patterns:**
- `| head -N`: Limit to first N lines
- `| tail -N`: Limit to last N lines  
- `| grep pattern`: Filter by content
- `| wc -l`: Count lines only
- `2>/dev/null`: Suppress error output

## 🔍 GREP TOOL PATTERNS

### Pattern 1: Precise Regex Patterns

**Vấn đề:** Generic patterns tạo nhiều false positives.

**Solution:** Sử dụng precise regex patterns.

**Ví dụ:**
```javascript
// ❌ Generic:
grep("function")  // Matches "function", "functional", etc.

// ✅ Precise:
grep("function\\s+\\w+\\s*\\(")  // Matches function definitions only
```

**Common Regex Patterns:**
- `function\\s+\\w+`: Function definitions
- `class\\s+\\w+`: Class definitions
- `const\\s+\\w+\\s*=`: Constant declarations
- `import\\s+.*from`: ES6 imports
- `export\\s+(const|function|class)`: Exports

### Pattern 2: Include/Exclude Filters

**Vấn đề:** Searching all files không hiệu quả.

**Solution:** Sử dụng `include` và `path` parameters.

**Ví dụ:**
```javascript
// ❌ Search everything:
grep("TODO")

// ✅ Targeted search:
grep("TODO", {include: "*.{js,ts}", path: "src/"})
```

**Filter Options:**
- `include: "*.js"`: Only JavaScript files
- `include: "*.{js,ts,tsx}"`: Multiple extensions
- `path: "src/"`: Specific directory
- Kết hợp cả hai để maximum efficiency

### Pattern 3: Combined with Glob

**Vấn đề:** Grep trên toàn bộ codebase.

**Solution:** Dùng glob trước để giới hạn scope.

**Ví dụ:**
```javascript
// Hiệu quả workflow:
const jsFiles = glob("src/**/*.js")
const results = grep("console\\.log", {include: "*.js", path: "src/"})
```

## 📁 GLOB TOOL PATTERNS

### Pattern 1: Targeted Patterns

**Vấn đề:** Broad patterns (`**/*`) tạo nhiều kết quả.

**Solution:** Sử dụng specific patterns.

**Ví dụ:**
```javascript
// ❌ Too broad:
glob("**/*")  // All files

// ✅ Targeted:
glob("src/**/*.{js,ts}")  // Only JS/TS files in src
```

**Effective Patterns:**
- `src/**/*.js`: All JS files in src
- `**/*test*.js`: Test files
- `**/*config*.{js,json}`: Config files
- `public/**/*.{css,js,html}`: Public assets

### Pattern 2: Directory Limiting

**Vấn đề:** Searching từ root directory.

**Solution:** Sử dụng `path` parameter.

**Ví dụ:**
```javascript
// ❌ From root:
glob("**/*.php")

// ✅ From specific directory:
glob("**/*.php", {path: "wp-content/"})
```

## 🤖 TASK TOOL PATTERNS

### Pattern 1: Delegation Strategy

**Vấn đề:** Complex searches tốn nhiều token.

**Solution:** Delegate cho Task tool.

**Ví dụ:**
```javascript
// ❌ Manual search:
glob("**/*.js")
grep("function")
read(multiple files)

// ✅ Delegated:
task("explore", "Find all function definitions in JavaScript files")
```

**When to Use Task Tool:**
- Complex multi-step searches
- Codebase exploration
- Research tasks
- When unsure về approach

### Pattern 2: Subagent Selection

**Vấn đề:** Chọn wrong subagent type.

**Solution:** Match subagent với task type.

**Guidelines:**
- `explore`: Codebase exploration, file searching
- `general`: Complex research, multi-step tasks
- Use description để guide agent

**Ví dụ:**
```javascript
// For code exploration:
task("explore", "Find all API endpoints in the codebase")

// For research:
task("general", "Research best practices for React performance optimization")
```

## 📝 EDIT/WRITE TOOL PATTERNS

### Pattern 1: Precise String Matching

**Vấn đề:** Edit failures do không tìm thấy exact string.

**Solution:** Sử dụng exact string từ file content.

**Ví dụ:**
```javascript
// ❌ May fail:
edit("file.js", "function foo()", "function bar()")

// ✅ Exact match:
edit("file.js", "function foo() {\n  return 42;\n}", "function bar() {\n  return 42;\n}")
```

**Best Practices:**
- Copy exact string từ read output
- Include surrounding context
- Preserve indentation

### Pattern 2: Batch Edits

**Vấn đề:** Multiple sequential edits.

**Solution:** Batch related edits.

**Ví dụ:**
```javascript
// ❌ Sequential:
edit("file1.js", "old1", "new1")
edit("file2.js", "old2", "new2")

// ✅ Batch:
[edit("file1.js", "old1", "new1"), edit("file2.js", "old2", "new2")]
```

### Pattern 3: ReplaceAll for Renaming

**Vấn đề:** Renaming across file cần nhiều edits.

**Solution:** Sử dụng `replaceAll` parameter.

**Ví dụ:**
```javascript
// Rename variable throughout file:
edit("file.js", "oldVarName", "newVarName", {replaceAll: true})
```

## 📊 TOOL USAGE DECISION TREE

### Khi nào dùng tool nào:

```
Start Task
├── Need to read file content?
│   ├── Large file? → Read with offset/limit
│   ├── Multiple files? → Batch reads
│   └── Specific section? → Grep first, then read
│
├── Need to execute commands?
│   ├── Multiple commands? → Chain với &&
│   ├── Different directory? → Use workdir
│   └── Large output? → Filter với head/grep
│
├── Need to search content?
│   ├── Know file patterns? → Glob + Grep
│   ├── Complex search? → Task tool
│   └── Simple pattern? → Grep với filters
│
├── Need to explore codebase?
│   └── Use Task tool với "explore" agent
│
└── Need to modify files?
    ├── Single edit? → Edit với exact string
    ├── Multiple edits? → Batch edits
    └── Rename throughout? → Edit với replaceAll
```

## ✅ BEST PRACTICES SUMMARY

### Do's:
- ✅ Use offset/limit cho large files
- ✅ Batch related operations
- ✅ Chain bash commands
- ✅ Use precise grep patterns
- ✅ Delegate complex tasks
- ✅ Measure token savings

### Don'ts:
- ❌ Read entire large files
- ❌ Sequential tool calls khi có thể batch
- ❌ Generic search patterns
- ❌ Manual exploration khi có thể delegate
- ❌ Edit without exact string matching

## 🔗 REFERENCE

- **Related Skills:** `001-opencode-token-optimization-guide.md`
- **Next Skills:** `003-batch-operations-examples.md`
- **Tool Documentation:** OpenCode tool specifications
- **Regex Reference:** MDN Web Docs Regex Guide

## 🧪 PRACTICE EXERCISES

**Exercise 1:** Optimize this workflow:
```javascript
read("package.json")
read("src/index.js") 
read("src/utils.js")
bash("npm run test")
```

**Exercise 2:** Convert sequential to batch:
```javascript
grep("function", {include: "*.js"})
grep("class", {include: "*.js"})
grep("const", {include: "*.js"})
```

**Exercise 3:** Chain these bash commands:
```javascript
bash("cd app")
bash("npm install")
bash("npm start")
```

---

**Pattern Count:** 15+ specific tool usage patterns  
**Applicability:** All OpenCode AI Assistant sessions  
**Tested With:** Real-world WordPress development tasks  
**Maintenance:** Update khi có tool changes hoặc patterns mới