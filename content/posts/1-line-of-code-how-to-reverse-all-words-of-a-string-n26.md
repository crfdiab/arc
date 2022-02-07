+++
title = "1 line of code How to reverse all words of a string"
author = "martin krause"
date = "2022-01-19T15:04:02Z"
description = "const reverseWords  str gt  strsplit mapword gt"
tags = ["javascript"," webdev"," productivity"," codequality"]
slug = "/1-line-of-code-how-to-reverse-all-words-of-a-string-n26/"
+++

```javascript
const reverseWords = (str) =>  str.split(" ").map((word) => [...word].reverse().join("")).join("");
```
 Returns the string with all words reversed

---

## Improved version with unicode support
```javascript
const reverseWords = (str) => str.replace(/(\p{L}+)/gu, (word) => [...word].reverse().join(''));
```

---

## The repository and npm package

You can find the all the utility functions from this series at [github.com/martinkr/onelinecode](https://github.com/martinkr/onelinecode)
The library is also published to [npm as @onelinecode](https://www.npmjs.com/package/@onelinecode/onelinecode) for your convenience.

The code and the npm package will be updated every time I publish a new article.

---

Follow me on [Twitter: @martinkr](http://twitter.com/_martinkr) and consider to [buy me a coffee](https://www.buymeacoffee.com/martinkr)

Photo by [zoo_monkey](https://unsplash.com/@zoo_monkey) on [Unsplash](https://unsplash.com/s/photos/fuji)

---

[![Subscribe to the weekly modern frontend development newsletter](https://modernfrontend.dev/banner/banner_583-111.png)](https://modernfrontend.dev/)

---
