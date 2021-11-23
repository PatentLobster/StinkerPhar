# Stinker helper package

This package is used internally within Stinker.

But can be used in vim as well:

in your .profile

```bash
export STINKER=$(pwd to index.php / Stinker.phar)
export STINKER_PROJECT=$(pwd to Laravel app)
```

in your .vimrc

```vim
function! s:Art()
	let b64 = system('base64', bufnr())
	botright new
	setlocal buftype=nofile bufhidden=wipe nobuflisted noswapfile nowrap	
	execute "$read !php $STINKER $STINKER_PROJECT tinker --tinker_code=".b64
	setlocal nomodifiable
	1
endfunction
command! -complete=shellcmd  Tinker call s:Art()
```
