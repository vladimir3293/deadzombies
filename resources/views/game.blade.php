@extends('layouts.layout')

@section('title','Аddddd')

@section('right_content')
    <div class="content">
        <h1>{{ $game->game_name }}</h1>
        <div class="breadcrumb">
            <span>BACK:</span>
            <a href="/">Home page</a>
            <a href="/<?php echo $game['cat_url'] . '/';?>"><?php echo $game['cat_name']?></a>
        </div>
        <div class="like">
            <img src="/img/like.png" alt="How many people like this game" title="like button">
            <span id="like_value"><?php echo $game['game_like'];?></span>
            <button id="like" data-id="<?php echo $game_id;?>">LIKE</button>
        </div>
        <div style="clear: both;"></div>
        <div class="upr">
            <img src="/img/control.png" alt="Управление">
            <p><?php echo $game['game_control'];?></p>
        </div>
        <div class="flash">
            <object width="700" height="<?php echo ceil(700 / $game['game_size']);?>"
                    type="application/x-shockwave-flash" data="/games/<?php echo $game['game_url'];?>.swf">
                <param name="movie" value="/games/<?php echo $game['game_url'];?>.swf">
                <param name="quality" value="high"/>
                <param name="wmode" value="transparent">
                <param name="bgcolor" value="#010101">
                <param name="autoplay" value="false">
            </object>
        </div>
        <div class="flash-opis">
            <img alt="<?php echo $game['game_title'];?>" title="<?php echo $game['game_name'];?>"
                 src="/img/<?php echo $game['game_url'] . '-first-medium.jpg';?>">
            <img alt="<?php echo $game['game_title'];?>" title="<?php echo $game['game_name'];?>"
                 src="/img/<?php echo $game['game_url'] . '-second-medium.jpg';?>">
            <img alt="<?php echo $game['game_title'];?>" title="<?php echo $game['game_name'];?>"
                 src="/img/<?php echo $game['game_url'] . '-third-medium.jpg';?>">
            <p><?php echo $game['game_desc'];?></p>
            <div class="clr"></div>
        </div>
    </div>
    </div>
@endsection