<a href="/"><img src="/img/logotype.png" alt="logotype"></a>
<div class="sidebar_inner">


    <div class="headline_others">
        <img src="/img/top-games.png">
        <span>TOP GAMES</span>
    </div>
    <div class="n_block">
        @if(isset($top_games))
        <?php foreach($top_games as $top_game_name=>$top_game_all):?>
        <div class="line">
            <a href="/<?php echo $top_game_all['cat_url'] . '/' . $top_game_all['game_url'] . '.html';?>"><img
                        alt="<?php echo $top_game_name;?>"
                        src="/img/<?php echo $top_game_all['game_url'] . '-first-small.jpg';?>"></a>
            <div class="right">
                <a href="/<?php echo $top_game_all['cat_url'] . '/' . $top_game_all['game_url'] . '.html';?>"><?php echo $top_game_name;?></a>
                <p class="playSide">Played:<?php echo $top_game_all['game_played'];?></p>
                <img src="/img/like.png" alt="How many people like this game" title="like button">
                <p class="likeSidebar"><?php echo $top_game_all['game_like'];?></p>
                <div class="clr"></div>
            </div>
        </div>
        <?php endforeach; ?>
        @endif
    </div>




    <ul class="main_menu">
        <li><a href="/">Home page</a></li>
        @if(isset($menu))
            @foreach($menu as $category)
                <li><a href="{!! $category->url !!}">{!! $category->cat_name !!}</a></li>
            @endforeach
        @endif
    </ul>


    <div class="headline_others">
        <img src="/img/new-games.png">
        <span>NEW GAMES</span>
    </div>
    <div class="n_block">
        @if(isset($new_games))
            <?php foreach($new_games as $new_game_name=>$new_game_all):?>
            <div class="line">
                <a href="/<?php echo $new_game_all['cat_url'] . '/' . $new_game_all['game_url'] . '.html';?>"><img
                            alt="<?php echo $new_game_name;?>"
                            src="/img/<?php echo $new_game_all['game_url'] . '-first-small.jpg';?>"></a>
                <div class="right">
                    <a href="/<?php echo $new_game_all['cat_url'] . '/' . $new_game_all['game_url'] . '.html';?>"><?php echo $new_game_name;?></a>
                    <div class="clr"></div>
                </div>
            </div>
            <?php endforeach; ?>
        @endif
    </div>
</div>


