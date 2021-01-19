<?php 
 
 
 

//Entity for Restaurants
 class Restaurant {

  private $name;
  private $rating;
  private $url;
  private $imgUrl;
  private $description;
  


  // Getter, Setter
  function set_name($name) {
    $this->name = $name;
  }
  function get_name() {
    return $this->name;
  }
  
  function set_rating($rating) {
    $this->rating = $rating;
  }
  function get_rating() {
    return $this->rating;
  }
  
  function set_url($url) {
    $this->url = $url;
  }
  function get_url() {
    return $this->url;
  }
  
   function set_imgUrl($imgUrl) {
    $this->imgUrl = $imgUrl;
  }
  function get_imgUrl() {
    return $this->imgUrl;
  }
  
  function set_description($description) {
    $this->description = $description;
  }
  function get_description() {
    return $this->description;
  }
  
}
 
    //Import API
	include('simple_html_dom.php');
 
    //get DOM from URL 
	$html = file_get_html('https://www.foodpanda.bg/en/city/sofia');

	//restaurant repository
	$restaurants = array();

	


//Get URLs
foreach($html->find('a.hreview-aggregate') as $a) {
	$newRest = new Restaurant();
	
	
	//Get RAW url for restaurant
	$rawUrl = $a->href;
	
	//Add missing url
	$formatedUrl = "https://www.foodpanda.bg" . $rawUrl;
	
	$newRest->set_url($formatedUrl);


	
	//Get Name
    foreach($a->find('span.name') as $name) {
		
		
		//Set Restaurant Name
		$newRest->set_name($name->innertext);

	}
	
	
	
	//Get Rating
	foreach($a->find('span.rating') as $rating) {
		
		
		//Set Restaurant Rating
		$newRest->set_rating($rating->innertext);

	}
	
	
	//Get Image URL
    foreach($a->find('div.vendor-picture') as $img) {
		
		//Return RAW img url 
		$rawImgUrl = $img->getAttribute("data-src"); 
		
		//Get correct img url(xxxxxxxx|img.jpg) 
		$imgUrl = substr($rawImgUrl, strpos($rawImgUrl, "|") + 1);
		
		//echo $imgUrl; TEST works
		
		//Set Restaurant IMG URL
		$newRest->set_imgUrl($imgUrl);

	}
	
	//Get Description
		foreach($a->find('li.vendor-characteristic') as $desc) {
			
					foreach($desc->find('span') as $sp) {
						//Get Description
						$rawDesc =  $sp->innertext ;
					}
					
				
					$newRest->set_description($rawDesc);
			
		}

	//Add entity to repo
	$restaurants[] = $newRest;
}




	



 //for random restaurat
	$i = rand(0,count($restaurants));



 ?> 
 
 
 

<html>
 <head>
  <title>Index</title>
    <link rel="stylesheet" href="./styles.css">


 </head>
 <body>
 <div class="polaroid">
 	<img src="  <?php echo($restaurants[$i]->get_imgUrl()) ;?>  ">
		<div class="restaurant">
					<span class="name"> <?php	echo($restaurants[$i]->get_name()) ;?> </span> <br>
					<span class="rating"> <?php	echo($restaurants[$i]->get_rating()) ;?> </span> <br>
					<span class="description">  <?php	echo($restaurants[$i]->get_description()) ;?> </span>   <br>
					<span class="buttons"> 
								<svg class="yes" >
										<a href="<?php	echo($restaurants[$i]->get_url()) ; ?>">
											<?php echo file_get_contents("dinner_yes.svg"); ?>
										</a> 

								</svg>
								<svg class="next">
								<a href="javascript:location.reload();">
									<?php echo file_get_contents("dinner_next.svg"); ?>
									</a>
								</svg>
					</span>
</div>
 </div>

 
 
 </body>
</html>