+++
title = "01 Product of Array Except Self"
author = "Sameer Kumar"
date = "2022-01-22T06:48:49Z"
description = "I have been discussing many topics in my blog but its time to start from the root once again In"
tags = ["algorithms"," codenewbie"," tutorial"," computerscience"]
slug = "/01-product-of-array-except-self-20ak/"
+++
I have been discussing many topics in my blog but it’s time to start from the root once again. In this blog and upcoming few we’ll discuss how to attempt general competitive programming questions, no fancy data structures or algorithms, but thinking outside the box and cooking up some good enough solutions together.

> Understanding how code works is more important than coding an app, Understanding how your own thoughts work is even more important.

**Imaginary problem time:**
---------------------------

> Given an integer array `nums`, return _an array_ `answer` _such that_ `answer[i]` _is equal to the product of all the elements of_ `nums` _except_ `nums[i]`.
> 
> _You must write an algorithm that runs in_ `_O(n)_` _time and without using the division operation._

Looks simple at the surface but digging in, we’ll find many good concepts. Don’t know if it's the right info or not, but leetcode says it was asked in these big shot interviews (Yeah! We can’t even guess which company names are blurred here, LOL!). 😅


![product of array except for self](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/e9mzq9msa8dngcu92m04.png)

**Solution time**
-----------------

nums = \[1, 2, 3, 4\]

Here, we need to find the product of all numbers except self and return results in an array. Easy-peezy!

1.  2\*3\*4 = 24
2.  1\*3\*4 = 12
3.  1\*2\*4 = 8
4.  1\*2\*3 = 6

Result: \[24, 12, 8, 6\]

**Algorithm**
-------------

Loop through nums and find **_product of all elements on left side and elements on right side._** It may sound simple but is important to know how we reached to this very solution among all possibilities.

## Implementation and Discussion
=============================

**Greedy way**
--------------

The most tempting way to solve such a problem will be to take the product of the entire array and divide it by the element for which we need the value. Like: If we need value for **b** then: (**a\*b\*c\*d) / b = a\*c\*d** , this is exactly we want for element b, right? Everything except **b**.  
This bubble will burst out when we need to consider a case when **b** is **0.**

```
Input: nums = [-1,1,0,-3,3]  
Output: [0,0,9,0,0]
```

In above case our logic will surely fail with result: \[0, 0, Infinity, 0, 0\].

**Rookie Ninja Way**
--------------------

A ninja always takes edge cases in consideration. One simple and stupid way to get it done is take product of all numbers on left side and multiply with products of all numbers on right side, giving product of all numbers except self: **product(\[-1, 1\] ) \* product(\[-3,3\]).** This solution will work for all cases, but one BIG problem ahead: Product is a heavy operation in itself and doing it for say 10,000 elements in the array, then it will result in **O(n²)** complexity and you’ll fail the test even after being a ninja.

**Ultimate Ninja Way**
----------------------

One beautiful way to do multiplication in such a case is this sweet algorithm: **Product till n-th element is product till (n-1)th element \* nth element.** Earlier, we had to multiply all elements of the array except to get that value, but now we take product till that number and just multiply itself. Done and dusted in **1** operation, where **n** operations were needed. This will take care of our left side product.

A small modification will take care of the right side as well. We start from the right end of the array, unlike the left product where we had to start from the left side, kinda intuitive! One catch in my implementation is the reversal of the right products to bring it in the same order as the left one, remember we filled the right products array in the opposite way.

Example: \[1,2,3,4,5,6,7,8\]  
For **4:  
Left product:** (Already calcalated product for **\[1, 2\]**) **\* 3 = 6  
Right product:** (Already calcalated product for **\[6, 7, 8\]**) **\* 5= 1680**

**Code**
--------

![Product of array except self solution in python](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/fvgoqem24rukpj7jpb74.png)
(https://github.com/sameer1612/CP-Solutions/blob/main/product_of_array_except_self.py)

**Conclusion**
--------------

This is a totally new area of discussion with you folks but no matter how many fancy technologies we touch or roles we cherish, we are coders and we code solutions to problems around us. I’ll like to write more of such blogs, maybe once a week if you like, do let me know.

## To Connect
==========

🏭 LinkedIn: [https://www.linkedin.com/in/sameerkumar1612  
/](https://www.linkedin.com/in/sameerkumar1612/)
🏠 Website: [https://hi-sameer.web.app](https://hi-sameer.web.app/)

![Not just another engineer](https://miro.medium.com/max/1400/1*9WTANLEDwnxXlIoSa8PNTw.png)