<?php 
namespace  Crm\CoreBundle\Pagination;

class Pagination{

	public function paginer(array $data,$url){
		
		$pagination = array();
		print_r($data);
		if(count($data) > 0 ){
			$data['url'] = $url;

			if($data['last'] > 4 ){
				if($data['page'] < 4 ){
					for ($i=1; $i <= 4; $i++) { 
						$pagination[] = array(
							'url'=>$url."&page=".$i,
							"libelle"=>$i
						);
					}
					if(($data['page'] +2) <  $data['last']){
						$pagination[] = array(
							'url'=>"#",
							"libelle"=>"..."
						);
					}
						
						$pagination[] = array(
							'url'=>$url."&page=".$data['last'],
							"libelle"=>$data['last']
						);
				}elseif ($data['page'] > 3) {
					$pagination[] = array(
							'url'=>$url."&page=1",
							"libelle"=>"1"
						);
					$pagination[] = array(
							'url'=>"#",
							"libelle"=>"..."
						);
					$pagination[] = array(
							'url'=>$url."&page=".($data['page']-1),
							"libelle"=>($data['page']-1)
						);
					$pagination[] = array(
							'url'=>$url."&page=".$data['page'],
							"libelle"=>$data['page']
						);
					if($data['page']+1 < $data['last']){
						$pagination[] = array(
							'url'=>$url."&page=".($data['page']+1),
							"libelle"=>($data['page']+1)
						);
						$pagination[] = array(
							'url'=>"#",
							"libelle"=>"..."
						);
					}
					if($data['page'] !=  $data['last'])
					$pagination[] = array(
							'url'=>$url."&page=".$data['last'],
							"libelle"=>$data['last']
						);

				}
			}else{
				// $pagination[] = array(
				// 			'url'=>$url."&page=1",
				// 			"libelle"=>"1"
				// 		);
				for ($i=1; $i <= $data['last']; $i++) { 
					$pagination[] = array(
							'url'=>$url."&page=".$i,
							"libelle"=>$i
						);
				}
				// $pagination[] = array(
				// 			'url'=>$url."&page=".$data['last'],
				// 			"libelle"=>$data['last']
				// 		);
			}

			return array("pagination"=>$pagination,
				"page"=>$data['page'],
				"last"=>$data['last']);
		}
		return array("pagination"=>array(),
			"page"=>0,
			"last"=>0);
	}
}