<?php

    class marvel_api {
    
        private $publickey;
        private $privatekey;
        public $ts;
        public $story;
        public $main_char;
        public $main_char_name;
        public $description;
        public $title;
        public $attribution;

        function __construct( $publickey, $privatekey, $main_char) {
            //init the attributes
            $this->publickey = $publickey;
            $this->privatekey = $privatekey;
            $this->main_char_name = $main_char;
            $this->ts = 0;
            $this->story = "";
            $this->main_char = "";
            $this->attribution = "";
            

        }



        function init_main_char()
        {
            //get the char id
            $md5_string = $this->gen_md5();
            $url_main_char = "http://gateway.marvel.com/v1/public/characters?name=".$this->main_char_name."&ts=".$this->ts."&apikey=".$this->publickey."&hash=".$md5_string;
            $this->main_char = json_decode(file_get_contents ($url_main_char));
            $main_char_id = $this->main_char->data->results[0]->id;
            $this->story = $this->get_random_story($this->main_char);    
            $this->attribution = $this->main_char->attributionHTML;
        }

        function get_random_story($character)
        {
            
            $story_index = rand ( 0 , $character->data->results[0]->stories->returned);
            $url_story =  $character->data->results[0]->stories->items[13]->resourceURI;
            $md5_string = $this->gen_md5();
            $url_story = $url_story."?ts=".$this->ts."&apikey=".$this->publickey."&hash=".$md5_string;
            return (json_decode(file_get_contents ($url_story)));
        }


        function list_story_char()
        {
            
            foreach ( $this->story->data->results[0]->characters->items as $character )
            {
                echo '<div class = "char">';
                echo '<figure>';
                //echo "<p>".$character->name;
                $md5_char = $this->gen_md5();
                $url_char = $character->resourceURI."?ts=".$this->ts."&apikey=".$this->publickey."&hash=".$md5_char;
                $json_char = json_decode(file_get_contents ($url_char));
                $char_avatar = $json_char->data->results[0]->thumbnail->path.".".$json_char->data->results[0]->thumbnail->extension;
                echo '<img src="'.$char_avatar.'" "weight ="150px" height="150px" >';
                echo '<figcaption>'.$character->name.'</figcaption>';

                echo '</figure>';

                echo '</div>';
            }

        }


        function print_story()
        {
            $this->description = $this->story->data->results[0]->description;
            $this->title = $this->story->data->results[0]->title;
        }



        function gen_md5()
        {
            $this->ts = new DateTime();
            $this->ts = $this->ts->getTimestamp();

            return(md5(($this->ts.$this->privatekey.$this->publickey)));

        }



    }

 ?>