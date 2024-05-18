                "result" => $result,
              ];
          }
      }
      return $this->failure();
    } catch (Exception $e) {
      return [
        "err" => "true",
        "message" => $e->getMessage(),
      ];
    }
  }
  
  private function failure()
  {

      @unlink($this->_config['cookie_file']);
      return false;
  }
  
  public function Data($url) 
  {
    $result = $this->getVideoByUrl($url);
    $err = $result["err"];
    
    if( $err == "true" ) {
      return $result;
      
    } elseif ( $err == "false") {
      $result = $result["result"];
      $title = $result->items[0]->desc;
      $uniqueId = $result->items[0]->author->uniqueId;
      $nickname = $result->items[0]->author->nickname;
      $imgUrl = $result->items[0]->author->avatarLarger;
      $titleFile = str_replace(" ", "-", $title);
      $filename = $this->generateName() . "_" . $titleFile;
      $playAddr = $result->items[0]->video->playAddr;
      $idVideo =  $result->items[0]->id;
      $embedVid = '<blockquote class="tiktok-embed" cite="https://www.tiktok.com/@' . $uniqueId . '/video/' . $idVideo . '" data-video-id="' . $idVideo . '" style="max-width: 605px;min-width: 325px;"><section></section></blockquote><script async src="https://www.tiktok.com/embed.js"></script>';
      
      return [
        "idVideo"  => $idVideo,
        "title"    => $title,
        "nickId"   => $uniqueId,
        "nickname" => $nickname,
        "filename" => $filename,
        "playAddr" => $playAddr,
        "imageUrl" => $imgUrl,
        "embedVid" => $embedVid,
        "err"      => "false",
      ];
    }
    
  }
  
}
