+++
title = "3 Simple steps to increase speed  efficiency while working  browsing"
author = "Alan"
date = "2022-01-31T00:42:07Z"
description = "If youre like me then you prefer to do everything on the computer without touching the mouse Its"
tags = ["programming"," webdev"," beginners"," productivity"]
slug = "/3-simple-steps-to-increase-speed-efficiency-while-working-browsing-42n0/"
+++
If you're like me then you prefer to do everything on the computer without touching the mouse. It's almost like a game sometimes. How can I open this program or browse this webpage without needing to lift my hands off of the keyboard? More specifically, how can I keep my fingers on the wasdf-jkli keys while navigating? Afterall, lifting my hand up to reach for the arrow keys is almost the same distance away as my mouse is. Too much effort!

If you resonate with any of what I just said, this article is for you. 

## 1: [Install Vimium](https://chrome.google.com/webstore/detail/vimium/dbepggeogbaibhgnhhndojpepiihcmeb) 
Vimium is a google chrome extension that allows you to browse the web with much more control than normal. 

Modern web pages are being designed with more and more accessibility features, such as built in tab-indexing, but it can still feel exhausting to have to cycle through every indexed element on the page to finally reach the one you want. I always overshoot it and have to shift tab another thirteen times to get back to where you want to be... 

Enter Vimium

Now you can easily scroll up and down on most pages using just the 'j' and 'k' keys and you can quickly access most elements of the page by pressing 'f' then typing the corresponding tags. Instead of using ctrl+F you can simply press the '/' slash key to insert your cursor at any text you search for. 

![A screen capture of a google search:"How to be a millionare in 2022" which has the Vimium extension activated and showing each selectable element](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/15qnajluiaz6269ulama.JPG)

## 2: Rebind your arrow keys to your 'j k l i' keys using [AutoHotkey](https://www.autohotkey.com/)
 
Control your cursor with Capslock + j k l i instead of your arrow keys. Trust me you don't need Capslock. You're not obnoxious are you? Just hold down shift. 

You'll need to first download & install AutoHotkey and write a script to remap your keyboard a little. Create a script file with the extension .ahk and copy and paste the following code

```
#NoEnv  ; Recommended for performance and compatibility with future AutoHotkey releases.
; #Warn  ; Enable warnings to assist with detecting common errors.
SendMode Input  ; Recommended for new scripts due to its superior speed and reliability.
SetWorkingDir %A_ScriptDir%  ; Ensures a consistent starting directory.

SetCapsLockState, AlwaysOff
CapsLock & j::Send, {blind}{Left}
CapsLock & k::Send, {blind}{Down}
CapsLock & l::Send, {blind}{Right}
CapsLock & i::Send, {blind}{Up}
CapsLock & h::Send, {blind}{Backspace}
```
I found this code from the following blog by a programmer named Nikita: [https://tonsky.me/blog/cursor-keys/](https://tonsky.me/blog/cursor-keys/) that explains why your cursor keys belong in the middle of your keyboard. Simply open up cmd and run the script from the directory you saved it in. 

Alternatively you can right click the script and select run. Pausing the script is done in the same manner.

Combined with Vimium you should now be browsing the internet and shuffling your cursor around your code at the speed of... your fingers? Anyways it's faster than lifting your hands off the keyboard. There is one more thing you can do to speed up your productivity.

## 3: Enable caret browsing
I almost spelled that 'carrot' instead. Anyone could make that mistake so don't judge me! Simply press F7 on Windows 10 to enable caret browsing. 

![A screen capture of the alert window that prompts the user to allow caret browsing after pressing F7](https://dev-to-uploads.s3.amazonaws.com/uploads/articles/5nv3oz48wvzqmyvylufo.JPG)

This makes copy paste scenarios faster and more satisfying.

Thanks for reading my 3 step process to speeding up your workflow. If you have any other 'power user' suggestions feel free to leave a comment. 

If you enjoyed this article please leave a like. 