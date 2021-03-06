<?php
/**
 * YAWIK
 *
 * @filesource
 * @copyright (c) 2013-2014 Cross Solution (http://cross-solution.de)
 * @license   MIT
 */

/** LinkedIn.php */ 
namespace Auth\Controller\Plugin\SocialProfiles;

class LinkedIn extends AbstractAdapter
{
    protected function queryApi($api)
    {
       $result = (array) $api->profile('~:(id,first-name,last-name,location,industry,public-profile-url,picture-url,email-address,date-of-birth,phone-numbers,summary,positions,educations,languages,last-modified-timestamp)');
       if(!isset( $result['success'] ) || !$result['success']) {
           return false;
       }
       
       $xml  = @ new \SimpleXMLElement($result['linkedin']);
       $data = $this->getDataArray($xml);
       
       return $data;
    }
    

    protected function getDataArray($xmlElement)
    {
        $return = array();
        
        foreach($xmlElement->children() as $child) {
            $name = $child->getName();
            
            switch ($name) {
                default: 
                    if (count($child->children())) {
                        $return[$name][] = $this->getDataArray($child);
                    } else {
                        $return[$name] = strval($child);
                    }
                    break;
                    
                case "location":
                    $return['location'] = array(
                        'name' => strval($child->name),
                        'country' => strval($child->country->code)
                    );
                    break;
                    
                case "relation-to-viewer":
                    $return['relation-to-viewer'] = strval($child->distance);
                    break;
                    
                case "connections":
                    $return['connections'] = $child['total'];
                    break;
                    
                case "positions":
                    $return['positions'] = $this->parsePositions($child);
                    break;
                    
                case "educations":
                    $return['educations'] = $this->parseEducations($child);
                    break;
            }
        }
        
        return $return;
    }
    
    protected function parsePositions($xml)
    {
        $positions = array();
        foreach ($xml->children() as $pos) {
            if ('position' != $pos->getName()) {
                continue;
            }
            
            $position = array();
            foreach ($pos->children() as $p) {
                $n = $p->getName();
                switch ($n) {
                    default:
                        $position[$n] = strval($p);
                        break;
                        
                    case 'start-date':
                    case 'end-date':
                        $position[$n] = $this->parseDate($p);
                        break;
                        
                    case 'company':
                        $position[$n] = strval($p->name);
                        break;
                }
            }
            $positions[] = $position;
        }
        
        return $positions;
    }
    
    protected function parseEducations($xml)
    {
        $educations = array();
        foreach ($xml->children() as $edu) {
            if ('education' != $edu->getName()) {
                continue;
            }

            $education = array();
            foreach ($edu->children() as $e) {
                $n = $e->getName();
                switch ($n) {
                    default:
                        $education[$n] = strval($e);
                        break;

                    case 'start-date':
                    case 'end-date':
                        $education[$n] = $this->parseDate($e);
                        break;
                }
            }
            $educations[] = $education;
        }
    
        return $educations;
    }
    
    protected function parseDate($xml)
    {
        return array(
            'year' => strval($xml->year),
            'month'=> isset($xml->month) ? strval($xml->month) : '01',
            'day'  => isset($xml->day)   ? strval($xml->day)   : '01',
        );
        
    }
}

