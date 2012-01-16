<?php
class ENeo4jGraphService extends EActiveResourceConnection
{      
    
    public $host='localhost';
    public $port='7474';
    public $db='db/data';
    public $contentType="application/json";
    public $acceptType="application/json";
    public $allowNullValues=false;
        
    public function init()
    {
        $this->site=$this->host.':'.$this->port.'/'.$this->db;
    }

    public function createBatchTransaction()
    {
        return new ENeo4jBatchTransaction($this);
    }

    public function queryByGremlin(EGremlinScript $gremlin)
    {
        Yii::trace(get_class($this).'.queryByGremlin()','ext.Neo4Yii.ENeo4jGraphService');
        
        $request=new EActiveResourceRequest;
        $request->setUri($this->site.'/ext/GremlinPlugin/graphdb/execute_script');
        $request->setMethod('POST');
        $request->setData(array('script'=>$gremlin->toString()));
        $response=$this->query($request);

        return $response;
    }          
}
?>