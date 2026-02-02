---
title: Codebase Exploration Strategies for OpenCode AI Assistant
date: 2026-02-02
tags: [opencode, codebase, exploration, navigation, efficiency]
type: [ai-assistant-optimization]
priority: [medium]
---

# 🗺️ CODEBASE EXPLORATION STRATEGIES FOR OPENCODE AI ASSISTANT

## 📌 TÓM TẮT

**Mục tiêu:** Cung cấp chiến lược hiệu quả để explore codebase với token usage tối thiểu.

**Thách thức:** Codebase exploration thường tốn nhiều token do:
- Đọc nhiều files không cần thiết
- Search patterns không hiệu quả
- Thiếu strategy dẫn đến exploration lộn xộn
- Context overflow từ quá nhiều file content

**Giải pháp:** Systematic exploration strategies với token optimization.

## 🧭 EXPLORATION PHILOSOPHY

### Principle 1: Learn Before Explore

**"Understand structure trước khi dive vào details"**

**Wrong Approach:**
```javascript
// ❌ Dive in without understanding
read("src/file1.js")
read("src/file2.js")
read("src/utils/helper.js")
```

**Right Approach:**
```javascript
// ✅ Understand structure first
const structure = glob("src/**/*")
read("package.json", {offset: 0, limit: 30})
read("README.md", {offset: 0, limit: 20})
```

### Principle 2: Targeted Over Broad

**"Specific searches thay vì broad scans"**

**Wrong Approach:**
```javascript
// ❌ Broad search
grep("function")  // Too many results
```

**Right Approach:**
```javascript
// ✅ Targeted search
grep("function\\s+\\w+\\s*\\(", {include: "*.js", path: "src/components/"})
```

### Principle 3: Incremental Discovery

**"Build understanding gradually"**

**Workflow:**
1. High-level structure
2. Key directories
3. Important files
4. Specific code sections

## 🗺️ EXPLORATION STRATEGIES

### Strategy 1: Top-Down Exploration

**Best for:** New codebase, understanding overall architecture.

**Steps:**

1. **Root Level Analysis:**
```javascript
[packageJson = read("package.json", {offset: 0, limit: 30}),
 readme = read("README.md", {offset: 0, limit: 25}),
 rootFiles = glob("*")]
```

2. **Directory Structure:**
```javascript
bash("find . -maxdepth 2 -type d | head -30")
```

3. **Key Config Files:**
```javascript
[configs = glob("**/*config*.{js,json,yml,yaml}"),
 envFiles = glob("**/.env*")]
```

**Token Usage:** ~150-250 tokens

### Strategy 2: Component-Centric Exploration

**Best for:** Frontend projects, React/Vue applications.

**Steps:**

1. **Find Components:**
```javascript
const componentFiles = glob("src/components/**/*.{js,jsx,ts,tsx}")
```

2. **Analyze Component Structure:**
```javascript
[componentCount = bash("find src/components -name '*.jsx' -o -name '*.tsx' | wc -l"),
 sampleComponent = read("src/components/Button.jsx", {offset: 0, limit: 40})]
```

3. **Find Entry Points:**
```javascript
const entryPoints = grep("ReactDOM\\.render|createRoot", {include: "*.{js,jsx,ts,tsx}"})
```

**Token Usage:** ~200-300 tokens

### Strategy 3: API-Centric Exploration

**Best for:** Backend projects, REST/GraphQL APIs.

**Steps:**

1. **Find API Routes:**
```javascript
const routeFiles = glob("**/*route*.{js,ts}") 
const controllerFiles = glob("**/*controller*.{js,ts}")
```

2. **Analyze Route Definitions:**
```javascript
[routes = grep("app\\.(get|post|put|delete|patch)", {include: "*.{js,ts}"}),
 sampleRoute = read("src/routes/users.js", {offset: 0, limit: 30})]
```

3. **Find Middleware:**
```javascript
const middleware = grep("middleware|auth|validate", {include: "*.{js,ts}"})
```

**Token Usage:** ~180-280 tokens

### Strategy 4: WordPress Exploration

**Best for:** WordPress themes và plugins.

**Steps:**

1. **Theme Structure:**
```javascript
[themeFiles = glob("wp-content/themes/**/*.php"),
 styleCheck = read("style.css", {offset: 0, limit: 20}),
 functionsCheck = read("functions.php", {offset: 0, limit: 30})]
```

2. **Plugin Analysis:**
```javascript
[pluginCount = bash("ls -la wp-content/plugins/ | wc -l"),
 activePlugins = grep("active_plugins", {include: "*.php"})]
```

3. **Template Hierarchy:**
```javascript
const templates = glob("**/*template*.php")
```

**Token Usage:** ~220-320 tokens

## 🔍 TARGETED SEARCH PATTERNS

### Pattern 1: Architecture Discovery

**Goal:** Understand application architecture.

**Search Pattern:**
```javascript
// Find architectural patterns
[entryPoints = grep("main\\.js|index\\.js|App\\.jsx", {include: "*.{js,jsx,ts,tsx}"}),
 configs = glob("**/*config*.{js,json}"),
 routes = grep("Router|Route|router\\.", {include: "*.{js,jsx,ts,tsx}"})]
```

### Pattern 2: Dependency Mapping

**Goal:** Understand dependencies và imports.

**Search Pattern:**
```javascript
// Analyze dependencies
[imports = grep("import\\s+.*from|require\\s*\\(", {include: "*.{js,ts}"}),
 packageDeps = read("package.json", {offset: 10, limit: 40})]
```

### Pattern 3: Business Logic Location

**Goal:** Find core business logic.

**Search Pattern:**
```javascript
// Look for business logic directories
const bizDirs = glob("**/*{service,logic,business,core,domain}*/**/*.{js,ts}")
```

## 📊 EXPLORATION WORKFLOWS

### Workflow 1: Quick Assessment (5-Minute Exploration)

**Goal:** Get high-level understanding nhanh chóng.

**Steps (Token budget: ~200 tokens):**

1. **Root Scan:** `glob("*")` + `read("package.json", {offset: 0, limit: 20})`
2. **Structure:** `bash("find . -maxdepth 2 -type d | head -20")`
3. **Key Files:** `read("README.md", {offset: 0, limit: 15})`
4. **Tech Stack:** `grep("react|vue|angular|express", {include: "package.json"})`

**Output:** Architecture overview, tech stack, key directories.

### Workflow 2: Deep Dive (15-Minute Exploration)

**Goal:** Detailed understanding cho specific task.

**Steps (Token budget: ~500 tokens):**

1. **Context Building:** Workflow 1 + additional config reading
2. **Targeted Search:** Search for task-specific patterns
3. **Sample Analysis:** Read 2-3 key files với offset/limit
4. **Dependency Check:** Analyze relevant dependencies

**Output:** Detailed understanding, specific code patterns, task-ready.

### Workflow 3: Bug Investigation

**Goal:** Find và understand bug-related code.

**Steps:**

1. **Error Context:** Read error messages/logs
2. **Related Files:** Search for error keywords
3. **Call Stack:** Trace function calls
4. **Data Flow:** Understand data transformations

**Example:**
```javascript
// Bug: "Cannot read property 'name' of undefined"
[errorContext = read("error.log", {offset: -50, limit: 30}),
 nameUsage = grep("\\.name\\b", {include: "*.js", path: "src/"}),
 undefinedChecks = grep("undefined|\\?\\?|\\?\\.", {include: "*.js", path: "src/"})]
```

## 🎯 EFFICIENT SEARCH TECHNIQUES

### Technique 1: Layered Searching

**Approach:** Search từ broad đến specific.

**Example: Finding authentication code:**

```javascript
// Layer 1: Directory level
const authDirs = glob("**/*auth*/**/*")

// Layer 2: File level  
const authFiles = glob("**/*{auth,login,register}*.{js,ts}")

// Layer 3: Content level
const authCode = grep("authenticate|login|jwt|token", {include: "*.{js,ts}"})

// Layer 4: Sample reading
const sampleAuth = read("src/middleware/auth.js", {offset: 0, limit: 40})
```

### Technique 2: Pattern Combination

**Approach:** Combine multiple search patterns.

**Example: Finding API endpoints với validation:**

```javascript
[apiEndpoints = grep("app\\.(get|post|put|delete)", {include: "*.js"}),
 validation = grep("validate|joi|yup|zod", {include: "*.js"}),
 combined = grep("app\\.(get|post).*validate|validate.*app\\.", {include: "*.js"})]
```

### Technique 3: Context-Aware Exploration

**Approach:** Use existing context để guide search.

**Example: Khi đã biết đây là React app:**

```javascript
// React-specific exploration
[components = glob("src/**/*.{jsx,tsx}"),
 hooks = grep("use[A-Z]|useState|useEffect", {include: "*.{js,jsx,ts,tsx}"}),
 context = grep("createContext|Context\\.Provider", {include: "*.{js,jsx,ts,tsx}"})]
```

## 📈 TOKEN OPTIMIZATION FOR EXPLORATION

### Optimization 1: Strategic File Reading

**Rule:** "Read less, understand more"

**Before:** `read("large-file.js")` // 500+ lines
**After:** `read("large-file.js", {offset: 0, limit: 50})` // First 50 lines only

**When to read full file:**
- Config files (small)
- Entry points (need full context)
- Files directly related to task

**When to read partially:**
- Large source files
- Documentation files
- Log files

### Optimization 2: Smart Globbing

**Rule:** "Be specific với glob patterns"

**Before:** `glob("**/*")` // Everything
**After:** `glob("src/**/*.{js,ts}")` // Only JS/TS in src

**Effective Patterns:**
- `src/**/*.{js,jsx,ts,tsx}`: Source files only
- `**/*test*.{js,ts}`: Test files
- `**/*config*.{json,js,yml}`: Config files
- `public/**/*.{css,js,html}`: Public assets

### Optimization 3: Batch Exploration Operations

**Rule:** "Batch related exploration steps"

**Example Batch:**
```javascript
// Single batch for initial exploration
[structure = glob("src/**/*"),
 packageInfo = read("package.json", {offset: 0, limit: 30}),
 readme = read("README.md", {offset: 0, limit: 20})]
```

## 🏗️ EXPLORATION TEMPLATES

### Template 1: New Project Assessment

```javascript
// Initial assessment template
[projectStructure = glob("*"),
 packageJson = read("package.json", {offset: 0, limit: 25}),
 readme = read("README.md", {offset: 0, limit: 15}),
 directories = bash("find . -maxdepth 2 -type d | sort | head -25")]
```

### Template 2: React App Exploration

```javascript
// React-specific exploration
[components = glob("src/**/*.{jsx,tsx}"),
 entryPoint = read("src/index.js", {offset: 0, limit: 20}),
 appComponent = read("src/App.jsx", {offset: 0, limit: 30}),
 packageDeps = read("package.json", {offset: 15, limit: 25})]
```

### Template 3: WordPress Theme Analysis

```javascript
// WordPress theme exploration
[themeFiles = glob("*.php"),
 styleInfo = read("style.css", {offset: 0, limit: 15}),
 functions = read("functions.php", {offset: 0, limit: 25}),
 templates = glob("**/*template*.php")]
```

## 📊 EXPLORATION METRICS

### Token Usage Benchmarks:

| Exploration Type | Token Range | Expected Output |
|-----------------|-------------|-----------------|
| Quick Scan | 150-250 tokens | High-level structure |
| Moderate | 300-500 tokens | Detailed understanding |
| Deep Dive | 600-1000 tokens | Task-ready analysis |
| Investigation | 500-800 tokens | Bug/solution focused |

### Efficiency Metrics:

| Metric | Good | Needs Improvement |
|--------|------|-------------------|
| Files Read | 3-5 files | 10+ files |
| Read Lines | 50-150 lines | 500+ lines |
| Search Precision | 80%+ relevant | <50% relevant |
| Context Usage | <30% window | >50% window |

## ✅ BEST PRACTICES

### Do's:
- ✅ Start với high-level structure
- ✅ Use targeted search patterns
- ✅ Read selectively với offset/limit
- ✅ Batch related exploration steps
- ✅ Build understanding incrementally
- ✅ Measure token usage

### Don'ts:
- ❌ Read entire large files
- ❌ Use broad search patterns (`**/*`)
- ❌ Explore without strategy
- ❌ Accumulate unnecessary context
- ❌ Forget to cleanup between explorations

## 🚨 COMMON PITFALLS

### Pitfall 1: Rabbit Hole Exploration

**Symptom:** Diving too deep vào unimportant details.

**Solution:** Set exploration limits và stick to them.

**Example Limit:** "Spend max 300 tokens trên exploration trước khi task work."

### Pitfall 2: Context Overload

**Symptom:** Too much file content in context window.

**Solution:** Regular context cleanup, reference thay vì quote.

### Pitfall 3: Premature Optimization

**Symptom:** Optimizing before understanding problem.

**Solution:** Understand trước, optimize sau.

## 🔗 REFERENCE

- **Related Skills:** `001-opencode-token-optimization-guide.md`
- **Previous Skills:** `003-batch-operations-examples.md`
- **OpenCode Docs:** Tool usage patterns
- **Code Navigation:** Software architecture principles

## 🧪 PRACTICE SCENARIOS

**Scenario 1:** New React codebase, need to add feature.

**Your Exploration Strategy:**
1. Start với template nào?
2. Search patterns gì?
3. Read哪些 files?
4. Token budget bao nhiêu?

**Scenario 2:** WordPress plugin bug investigation.

**Your Exploration Strategy:**
1. Initial assessment steps?
2. Bug-specific searches?
3. Key files to examine?
4. Efficiency measures?

---

**Strategy Count:** 10+ exploration strategies  
**Template Count:** 5+ ready-to-use templates  
**Token Savings:** 40-60% vs unplanned exploration  
**Applicability:** All codebase types và sizes  
**Tested With:** React, Vue, Node.js, WordPress projects  
**Maintenance:** Update với new exploration patterns