<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GridHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\Entity\Grid;
use Dataware\Entity\GridColumn;
use Dataware\Entity\GridAction;
use Zend\Form\Annotation\AnnotationBuilder;

class GridHelper extends ViewHelper
{
    public function __invoke(Grid $grid)
    {
        $displayGrid = $grid->getGenerateFieldset() ? "<fieldset>" : "";
        $displayGrid .= "<div id='grid_wrapper' class='dataTables_wrapper form-inline no-footer'>
                             <div class='table'>
                                 <table cellpadding='0' cellspacing='0' border='0' class='table table-striped table-bordered dataTable no-footer' id='grid' role='grid' aria-describedby='grid_info'>
                                     <thead>
                                         <tr role='row'>";
        
        // Cria as colunas da grid, baseadas nos atributos da entidade.
        $this->makeGridColumnsByEntity($grid);
        
        // Gera o cabeçalho da grid, caso esitam colunas atribuidas.
        $displayGrid .= $this->generateGridColumns($grid);
        $displayGrid .= "                </tr>
                                     </thead>
                                     <tbody>";
        
        // Prepara as ações padrões que serão utilizadas na grid.
        $this->makeDefaultGridActions($grid);
        
        // Gera o corpo da grid, contendo os registros obtidos para a listagem.
        $displayGrid .= $this->generateGridRows($grid);
        $displayGrid .= "            </tbody>
                                 </table>
                             </div>
                         </div>";
        $displayGrid .= $grid->getGenerateFieldset() ? "</fieldset>" : "";
        
        return $displayGrid;
    }
    
    /**
     * Primerio oter todos os atributos da classe de forma automática;
     * Depois, obter todos atributos que possuem annotações que serão utilizadas;
     * Estes atributos serão gerados na grid. 
     * 
     * @param \Dataware\Entity\Grid $grid
     */
    private function makeGridColumnsByEntity(Grid $grid)
    {
        if ( strlen($grid->getEntity()) > 0 )
        {
            $annotationBuilder = new AnnotationBuilder();
            $formEspecification = $annotationBuilder->getFormSpecification($grid->getEntity());

            foreach ( $formEspecification['elements'] as $element )
            {
                if ( strlen($element['spec']['options']['label']) > 0 )
                {
                    // É possível a partir do tipo, conseguir descobrir o alinhamento dos registros.
                    $gridColumn = new GridColumn($element['spec']['name'], $element['spec']['options']['label']);
                    $grid->addColumn($gridColumn);
                }
            }
        }
    }
    
    /**
     * Gera o cabeçalho da grid.
     * 
     * @param \Dataware\Entity\Grid $grid
     * @return string html
     */
    private function generateGridColumns(Grid $grid)
    {
        $headerGrid = "";
        
        if ( count($grid->getColumns()) > 0 )
        {
            foreach ( $grid->getColumns() as $gridColumn )
            {
                $headerGrid .= $this->generateGridColumn($gridColumn);
            }
        }      
        
        // Gera a coluna de ações dos registros na grid.
        $gridColumnActions = new GridColumn(GridColumn::GRID_COLUMN_ACTIONS_ID, GridColumn::GRID_COLUMN_ACTIONS_TITLE);
        $gridColumnActions->setStyle("width: 100px !important");
        $headerGrid .= $this->generateGridColumn($gridColumnActions);
        
        return $headerGrid;
    }
    
    /**
     * Gera o html de uma coluna para a grid.
     * 
     * @param \Dataware\Entity\GridColumn $gridColumn
     * @return string
     */
    private function generateGridColumn(GridColumn $gridColumn)
    {
        return "<th class='{$gridColumn->getClass()}' 
                    tabindex='{$gridColumn->getTabIndex()}' 
                    aria-controls='{$gridColumn->getAriaControls()}' 
                    rowspan='{$gridColumn->getRowSpan()}' 
                    colspan='{$gridColumn->getColSpan()}' 
                    aria-sort='{$gridColumn->getAriaSort()}' 
                    style='{$gridColumn->getStyle()}'
                    width='{$gridColumn->getWidth()}'
                    height='{$gridColumn->getHeight()}'>
                    {$gridColumn->getTitle()}
                </th>";
    }
    
    /**
     * Cria as ações padrões, que serão renderizadas 
     * para os registros na grid.
     * 
     * @param \Dataware\Entity\Grid $grid
     */
    private function makeDefaultGridActions(Grid $grid)
    {
        if ( !$grid->defaultGridActionsAreHidden() )
        {
            $route = $this->getCurrentRoute();

            //$grid->addGridAction(new GridAction(GridAction::GRID_ACTION_VIEW_ID, "Visualizar", $route, 'view', "fa-eye"));
            $grid->addGridAction(new GridAction(GridAction::GRID_ACTION_ATTACHMENT_ID, "Anexos", $route, 'attachments', "fa-paperclip"));
            $grid->addGridAction(new GridAction(GridAction::GRID_ACTION_EDIT_ID, "Editar", $route, 'edit', "fa-pencil-square-o"));
            $grid->addGridAction(new GridAction(GridAction::GRID_ACTION_DELETE_ID, "Excluir", $route, 'delete', "fa-trash-o"));
        }
    }
    
    /**
     * Gera os registros que serão listados na grid.
     * 
     * @param \Dataware\Entity\Grid $grid
     * @return string
     */
    private function generateGridRows(Grid $grid)
    {
        $rows = "";
        $cont = 0;
        
        if ( count($grid->getData()) > 0 )
        {
            foreach ( $grid->getData() as $gridData )
            {
                $classColor = ($cont % 2 == 0) ? 'odd' : 'even'; $cont++;
                $rows .= "<tr class='gradeA {$classColor}' role='row'>";                

                // Gera os dados do registro.
                foreach ( $grid->getColumns() as $gridColumn )
                {
                    if ( $grid->hasEntity() )
                    {
                        $lowerColumn = strtolower($gridColumn->getId());
                        $getFunction = "get" . ucfirst($lowerColumn);
                        $tdValue = "";

                        if ( method_exists($gridData, $getFunction) )
                        {
                            $data = $gridData->$getFunction();
                            $value = $data;

                            // Para registros relacionais.
                            $value = $this->adjustToShowRelationalEntityValue($value);

                            // Para registros booleanos.
                            $value = $this->adjustToShowBooleanValue($value);
                            
                            // Para registros de senha
                            $value = $this->adjustToShowPasswordValue($value);
                            
                            $tdValue .= $value;
                        }
                    }
                    else
                    {
                        $tdValue = $gridData[$gridColumn->getId()];
                    }   
                    
                    $rows .= "<td>{$tdValue}</td>";
                }
                
                // Gera as ações padrões dos registros na grid (Editar e Excluir).
                $rows .= $this->makeGridRowActions($grid, $gridData);
                $rows .= "</tr>";
            }
        }
        
        return $rows;
    }
    
    /**
     * Verifica se o valor é um objeto relacional, e ajusta
     * os dados necessários para exibição na grid.
     * 
     * @param string $value
     */
    private function adjustToShowRelationalEntityValue($value)
    {
        if ( is_object($value) )
        {   
            // Se o objeto for um file, cria um link para efetuar o donwload do arquivo.
            if ( $value instanceof \Dataware\Entity\File )
            {
                $urlHelper = $this->getUrlHelper();
                $route = $this->getCurrentRoute();                
                
                $href = $urlHelper($route) . "/downloadfile/" . $value->getId();
                $value = "<a href='{$href}' target='_blank'>{$value->getTitle()}</a>";
            }
            else
            {
                $value = $value->getId() . ' - ' . $value->getTitle();
            }
        }
        
        return $value;
    }
    
    /**
     * Verifica se o valor é booleano, e ajusta
     * os dados necessários para exibição na grid.
     * 
     * @param type $value
     */
    private function adjustToShowBooleanValue($value)
    {
        if ( $value === true )
        {
            $value = "<font color='green'>" . GridColumn::GRID_VALUE_BOOLEAN_TRUE . "</font>";
        }
        else if ( $value === false )
        {
            $value = "<font color='red'>" . GridColumn::GRID_VALUE_BOOLEAN_FALSE . "</font>";
        }
        
        return $value;
    }
    
    /**
     * Verifica se o valor é de campo senha,
     * e ajusta para retornar somente 
     * **********
     * 
     * @param type $value
     * @return type
     */
    private function adjustToShowPasswordValue($value)
    {
        if ( preg_match('/^[a-f0-9]{32}$/', $value) )
        {
            $value = "************";
        }
        
        return $value;        
    }
    
    /**
     * Cria as ações padrões para um registro da grid
     * 
     * @param obj $entity
     * @return string html
     */
    private function makeGridRowActions(Grid $grid, $gridData)
    {
        $actions = "<td>";
        $args = array();
        
        // Para registros por entidades.
        if ( $grid->hasEntity() && is_object($gridData) )
        {   
            foreach ( $grid->getIdentityColumns() as $identityColumn )
            {
                $getFunction = "get" . ucfirst($identityColumn);

                if ( method_exists($gridData, $getFunction) )
                {
                    $args[$identityColumn] = $gridData->$getFunction();
                }
            }
        }    
        
        // Para registros em array
        else if ( is_array($gridData) )
        {
            foreach ( $grid->getIdentityColumns() as $identityColumn )
            {
                $args[$identityColumn] = $gridData[$identityColumn];
            }
        }
        
        $actions .= $this->generateGridRowActions($grid, $args);
        
        return $actions . "</td>";
    }
    
    /**
     * Gera as ações do registro na grid.
     * 
     * @param \Dataware\Entity\Grid $grid
     * @return String html
     */
    public function generateGridRowActions(Grid $grid, $args = array())
    {
        $actions = "";
        $gridActions = $grid->getGridActions();
        $disableGridActions = $grid->getDisableActions();
        
        if ( count($gridActions) > 0 )
        {
            foreach ( $gridActions as $gridAction )
            {
                if ( !in_array($gridAction->getId(), $disableGridActions) )
                {
                    $gridAction->setArgs($args);
                    $actions .= $this->view->GridActionHelper($gridAction);
                }
            }
        }
        
        return $actions;
    }
}

?>
