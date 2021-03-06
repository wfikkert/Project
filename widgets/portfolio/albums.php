<?php
//Daan Stout
/*
een widget moet altijd een functie bevatten die net zo heet als de Widget tag
bijv. tag: {{ portfolio_albums }}, functie naam: portfolio_albums.

je mag NOOIT echo/print gebruiken in een functie.
Als je dit wel doet, dan wordt de text die je wilt latenzien boven de pagina getoond, en dat willen we niet.
dus gewoon return.

Je kan hele html strings returne, dus dat is geen probleem.

Als je iets met mysql wilt doen in een widget, moet je altijd "global $mysqli;" gebruiken, anders zal het niet werken.

*/

function portfolio_albums(){
    global $mysqli;

    $result = $mysqli->query("SELECT * FROM portfolio ORDER BY id DESC");
    //dit haalt alle portfolios op die in de database staan
    while($item = $result->fetch_object()){
        $portfolio .= '
        <figure>
            <a href="/portfolio-fotos/'.$item->id.'">
                <img id="thumb" src="/thumb.php?photo='.$item->prev_photo.'&type=portfolio" alt="'.$item->name.'"/>
                <figcaption>'.$item->name.'</figcaption>
            </a>
        </figure>
        ';
        /* deze while laat de portfolios zien met als coverfoto de eerste foto in de map, 
         * zolang ze er zijn en zorgt ervoor dat je op de foto kan klikken
         * als je op de foto klikt krijg je de portfolio te zien. 
         */
        
    }
    
    return $portfolio;

}



