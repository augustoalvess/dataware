<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DiaryHelper
 *
 * @author augusto
 */
namespace Dataware\View\Helper;

use Dataware\View\Helper\ViewHelper;
use Dataware\Entity\Diary;
use Dataware\Entity\DiaryEvent;

class DiaryHelper extends ViewHelper
{
    public function __invoke(Diary $diary) 
    {
        $eventsRender = "";
        
        if ( count($diary->getEvents()) > 0 )
        {
            foreach ( $diary->getEvents() as $event )
            {
                if ( $event instanceof DiaryEvent )
                {
                    $eventsRender .= "
                    {
                        events: [{
                            id: " . json_encode($event->getId()) . ",
                            title: '{$event->getTitle()}',
                            start: '{$event->getStart()}',
                            end: '{$event->getEnd()}',
                            allDay: " . json_encode($event->getAllDay()) . "
                        }],
                        textColor: '{$event->getColor()}'
                    },";
                }
            }
        }
        
        $diaryRender = "
        <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar( {
                defaultDate: '{$diary->getDefaultDate()}',
                lang: '{$diary->getLang()}',
                header: {
                    left: '{$diary->getHeaderLeft()}',
                    center: '{$diary->getHeaderCenter()}',
                    right: '{$diary->getHeaderRight()}'
                },
                selectable: " . json_encode($diary->getSelectable()) . ",
                selectHelper: " . json_encode($diary->getSelectHelper()) . ",
                select: function(start, end) {
                    $('#obscure-loading').fadeIn('slow');
                    window.location.href = '{$diary->getAddAction()}?selected_date=' + start.format();
                },
                eventClick: function(event, jsEvent, view) {
                    $('#obscure-loading').fadeIn('slow');
                    window.location.href = '{$diary->getEditAction()}/' + event.id;
                },
                editable: " . json_encode($diary->getEditable()) . ",
                eventLimit: " . json_encode($diary->getEventLimit()) . ",
                eventSources: [{$eventsRender}]
            });
        });
        </script>

        <fieldset>
            <div id='calendar'></div>
        </fieldset>";
        
        return $diaryRender;
    }
}

?>
