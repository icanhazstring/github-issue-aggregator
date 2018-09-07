github issue aggregator
---
dependencies:
- knplabs/github-api 
- knplabs/packagist-api
---

## process steps
### 1. load root composer.json (check)

    GET /repos/:owner/:repo/contents/composer.json
    Host https://api.github.com
    Accept: application/vnd.github.v3.raw

### 2. parse root dependencies
- pattern `/owner\/repo/`
- save owner/repo to get issues
  - read repo from packagist api
  -     GET /search.json?q=[query]
        Host: https://packagist.org
  - parse repository from 
  -     {repository: "https:\/\/github.com\/sebastianbergmann\/version"}

### 3. load issues

    GET repos/:owner/:repo/issues
    Host: https://api.github.com/

Content:
- title
- html_url
- comments
- created_at
- updated_at
- state (open, closed)
