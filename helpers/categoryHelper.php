<?php

class CategoryHelper extends BaseHelper {
    public function getOutput() {
        $output = parent::getOutput();
        unset($output['uri']); 
        unset($output['colourclass']); 
        unset($output['active']); 
        unset($output['hidden']);
        unset($output['description']);
        
        $i = 1;
        for($i; $i <=4; $i++) {
            unset($output['top_slider_'.$i]); 
            unset($output['top_sidebar_'.$i]); 
        }
        foreach($this->this->getTopStories() as $key => $article) {
            $index = str_replace('top_story_', '', $key);
            //$output['top_stories'][$index] = $article->getOutput();
        }
        return $output;
    }
}
