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

### 2. parse root dependencies (check)
- pattern `/owner\/repo/`
- save owner/repo to get issues
  - read repo from packagist api
  -     GET /search.json?q=[query]
        Host: https://packagist.org
  - parse repository from 
  -     {repository: "https:\/\/github.com\/sebastianbergmann\/version"}

### 3. github oauth
- login using github oauth for personal access token

### 4. load issues

    GET repos/:owner/:repo/issues
    Host: https://api.github.com/

Content:
- title
- html_url
- comments
- created_at
- updated_at
- state (open, closed)

## access credentials
- clientid: 5dc033f15a7550914993
- clientsecret: 66c94c452b4f92e8c09fdbdb255f0fa1c73640a1
