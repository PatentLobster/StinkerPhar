# Stinker helper package

This package is used internally within Stinker.

But can be used in vim as well:

in your .profile

```bash
export STINKER=$(pwd to index.php / Stinker.phar)
```

in your .vimrc

```vim
function! s:Art()
	let b64 = system('base64', bufnr())
	botright new
	setlocal buftype=nofile bufhidden=wipe nobuflisted noswapfile nowrap	
	execute "$read !php $STINKER /Users/itzik/Repos/lplayground tinker --tinker_code=".b64
	setlocal nomodifiable
	1
endfunction
command! -complete=shellcmd  Tinker call s:Art()
```
