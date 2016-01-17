<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MultiUploadHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Attachment;

class MultiUploaderHelper extends ViewHelper
{
    public function __invoke(Attachment $attachment) 
    {    
        $folder = "uploads/entities/" . $attachment->getEntityName() . '/' . $attachment->getEntityId();
        $filePath = dirname(__DIR__) . "/../../../../../public/" . $folder;

        if ( !is_dir($filePath) )
        {
            mkdir($filePath, 0777, true);
        }
        
        $applicationConfig = $this->getView()->getHelperPluginManager()->getServiceLocator()->get('config');
        $uploadImageBasePath = $this->view->basePath($applicationConfig['upload_image_base_path']);
        $folder = $uploadImageBasePath . $folder;
        
        $content = "
            <script>
                $(document).ready(function() {
                    $('#file_upload').uploadify({
                        'uploader'  : '{$this->view->basePath('uploadify/uploadify.swf')}',
                        'script'    : '{$this->view->basePath('uploadify/uploadify.php')}',
                        'cancelImg' : '{$this->view->basePath('uploadify/cancel.png')}',
                        'folder'    : '{$this->view->basePath($folder)}',
                        'auto'      : false, // False para não começar automaticamente, e True para começar o upload automaticamente.
                        'multi'     : true, // False para fazer upload apenas de um arquivo e True para vários arquivos.
                        'onAllComplete' : function(event, data) 
                        {   
                            swal(
                            {
                                title: 'Ok!',   
                                text: 'Upload dos anexos efetuados com sucesso!',   
                                type: 'success',   
                                showCancelButton: false,   
                                confirmButtonColor: 'rgb(174, 222, 244)',   
                                confirmButtonText: 'OK',    
                                closeOnConfirm: false
                            }, 
                            function ( isConfirm )
                            {   
                                if ( isConfirm ) 
                                {   
                                    window.location.reload();
                                } 
                            });
                        } 
                    });
                });
            </script>
            
            
            <div class='multiupload'>
                <a style='float:right; margin-left: 5px;' href=\"javascript:$('#file_upload').uploadifyUpload();\" >
                    <button class='btn btn-primary loading'>Salvar arquivos</button>
                </a>
                <a style='float:right; margin-left: 10px;' href=\"javascript:$('#file_upload').uploadifyClearQueue();\" >
                    <button class='btn btn-danger'>Cancelar arquivos</button>
                </a>
                <input type='file' class='input-text btn' id='file_upload'/>
            </div>";
        
        return $content;
    }
}

?>
