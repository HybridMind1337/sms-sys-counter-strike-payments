<?php
/**
 * @class General
 * @created 06/04/2023 г.
 *
 * @author HybridMind
 * @email hybridmind1337@gmail.com
 * @discord HybridMind#6095
 *
 */


namespace App\Controllers\Admin;

use App\Kernal;

class General extends Kernal
{

    public function index()
    {
        Auth();
        $this->renderView('admin/index');
    }
}