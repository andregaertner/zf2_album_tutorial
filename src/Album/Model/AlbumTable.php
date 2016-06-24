<?php
namespace Album\Model;

use Zend\Db\TableGateway\TableGateway;

class AlbumTable
{
	protected $tableGateway;
	
	/**
	 * @method Constructor
	 */
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	/**
	 * @method fetchAll
	 */
	public function fetchAll()
	{
		$resultSet = $this->tableGateway->select();
		return $resultSet;
	}
	
	/**
	 * @method getAlbum
	 */
	public function getAlbum($id)
	{
		$id  = (int) $id;
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		
		if (!$row) {
			throw new \Exception("Could not find row $id");
		}
		
		return $row;
	}
	
	/**
	 * @method saveAlbum
	 * @param $album
	 */
	public function saveAlbum(Album $album)
	{
		$data = array(
			'artist' => $album->artist,
			'title'  => $album->title,
		);
		
		$id = (int) $album->id;
		if ($id == 0)
		{
			$this->tableGateway->insert($data);
		} 
		else 
		{
			if ($this->getAlbum($id))
			{
				$this->tableGateway->update($data, array('id' => $id));
			} 
			else 
			{
				throw new \Exception('Album id does not exist');
			}
		}
	}
	
	/**
	 * @method deleteAlbum
	 * @param $id
	 */
	public function deleteAlbum($id)
	{
		$this->tableGateway->delete(array('id' => (int) $id));
	}
}