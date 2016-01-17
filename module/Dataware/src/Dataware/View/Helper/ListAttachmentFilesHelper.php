<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AttachmentFilesHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Attachment;
use Dataware\Entity\Grid;
use Dataware\Entity\GridColumn;
use Dataware\Entity\GridAction;

class ListAttachmentFilesHelper extends ViewHelper
{
    public function __invoke(Attachment $attachment)
    {
        $folder = "uploads/entities/" . $attachment->getEntityName() . '/' . $attachment->getEntityId();
        $filePath = dirname(__DIR__) . "/../../../../../public/" . $folder;
        
        $grid = new Grid();
        $grid->setHasEntity(false);
        
        $grid->addColumn(new GridColumn('file', "Arquivo", 50));
        $grid->addColumn(new GridColumn('title', "Título"));
        $grid->addColumn(new GridColumn('type', "Tipo"));
        $grid->addColumn(new GridColumn('path', "Caminho"));
        $grid->addColumn(new GridColumn('size', "Tamanho"));

        $gridData = array();

        if ( is_dir($filePath) )
        {            
            $dir = opendir($filePath);
            
            while ( $read = readdir($dir) ) 
            {
                if ( ( $read != '.' ) && ( $read != '..' ) ) 
                {
                    $fileName = $filePath . '/' . $read;
                    $path = $this->view->basePath($folder . '/' . $read);
                    $pathInfo = pathinfo($path);
                    $mimeType = $pathInfo['extension'];
                    $fileSize = number_format(filesize($fileName) / 1048576, 2) . ' MB';
                    
                    $gridData[] = array(
                        'file' => "<a href=\"javascript:popupImage('{$path}');\">
                                       <img src='{$path}' title='Clique para ampliar' width='50' height='50'/>
                                   </a>",
                        'title' => $pathInfo['basename'],
                        'type' => strtoupper($mimeType),
                        'path' => $path,
                        'size' => $fileSize,
                        GridColumn::GRID_IDENTITY_COLUMN_DEFAULT => $attachment->getEntityId(),
                        'attachment' => $pathInfo['basename']
                    );
                }       
            }
            
            $grid->setData($gridData);
        }
        
        $route = $this->getCurrentRoute();        
        $grid->hideDefaultGridActions(true);        
        $grid->addGridAction(new GridAction(GridAction::GRID_ACTION_DELETE_ID, "Excluir anexo", $route, 'removeattachment', "fa-trash-o"));
        $grid->setIdentityColumns(array(GridColumn::GRID_IDENTITY_COLUMN_DEFAULT, 'attachment'));
        
        return $this->view->GridHelper($grid);;
    }
}

?>
