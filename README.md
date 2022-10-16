<p align="center" width="100%">
    <img width="15%" src="https://github.com/PatentLobster/stinker/raw/master/public/icon.png"> 
</p>

<h1 align="center"> Stinker helper package </h1>

<p align="center">This package is used internally within Stinker. </p>

<p align="center"> But can be used in vim as well: </p>



<p align="center">in your .profile</p>
<br/>


```bash
export STINKER=$(pwd to index.php / Stinker.phar)
export STINKER_PROJECT=$(pwd to Laravel app)
```


<br/>


<p align="center"> in your .vimrc </p>
<br/>


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
