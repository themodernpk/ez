<?php

class HtmlHelper
{

    //----------------------------------------------
    /*
     * array("" => "");
     * $data['title'] = "Modal Title";
     * $data['modal_id'] = "Add";
     * $data['title'] = "#modal-email";
     */
    public static function modal($data=array())
    {
        $data['start'] = true;

        $view  = View::make('core::elements.modal')->with('data', $data);
        return $view;
    }
    //----------------------------------------------
    public static function modalClose()
    {
        $data['end'] = true;

        $view  = View::make('core::elements.modal')->with('data', $data);
        return $view;
    }
    //----------------------------------------------
    /*
     * array("title" => "Panel Title", "head_button" => "Add", "head_button_modal_id" => "#modalID")
     * $data['title'] = "Panel Title";
     * $data['head_button'] = "Add";
     * $data['head_button_modal_id'] = "#modal-email";
     */
    public static function panel($data = array())
    {

        $data['start'] = true;

        $view  = View::make('core::elements.panel')->with('data', $data);
        return $view;

    }
    //----------------------------------------------
    public static function panelClose()
    {
        $data = array();
        $data['end'] = true;
        $view  = View::make('core::elements.panel')->with('data', $data);
        return $view;

    }
    //----------------------------------------------

    public static function collapsiblePanel($id)
    {
        $data['start'] = true;
        $data['id'] = $id;

        $view  = View::make('core::elements.collapsiblePanel')->with('data', $data);
        return $view;

    }

    //----------------------------------------------
    public static function collapsiblePanelClose()
    {
        $data['end'] = true;

        $view  = View::make('core::elements.collapsiblePanel')->with('data', $data);
        return $view;
    }

    //----------------------------------------------
    public static function collapsiblePanelItemTitleStart($panel_id, $panel_item_id)
    {
        $data['title_start'] = true;
        $data['panel_id'] = $panel_id;
        $data['panel_item_id'] = $panel_item_id;

        $view  = View::make('core::elements.collapsiblePanel')->with('data', $data);
        return $view;
    }
    //----------------------------------------------
    public static function collapsiblePanelItemTitleClose()
    {
        $data['title_end'] = true;

        $view  = View::make('core::elements.collapsiblePanel')->with('data', $data);
        return $view;
    }
    //----------------------------------------------
    public static function collapsiblePanelItemBodyStart($panel_item_id)
    {
        $data['body_start'] = true;
        $data['panel_item_id'] = $panel_item_id;

        $view  = View::make('core::elements.collapsiblePanel')->with('data', $data);
        return $view;
    }
    //----------------------------------------------
    public static function collapsiblePanelItemBodyClose()
    {
        $data['body_end'] = true;

        $view  = View::make('core::elements.collapsiblePanel')->with('data', $data);
        return $view;
    }
    //----------------------------------------------

}// end of class