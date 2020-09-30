        </div>
        <div class="container footer">
            <?if(sess('user_id') > 0){?>
                <a href="<?=URL?>/login/logout">Log out </a>
            <?}?>
        
        </div>  
    </body>
</html>