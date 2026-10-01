<?php

namespace App\Models\Master;

use CodeIgniter\Model;

class TemplateModel extends Model
{
    protected $table = "setting";
    protected $primaryKey = "id";
    protected $allowedFields = ["logo", "favicon", "logoMobile", "linkFacebook", "linkTwitter", "linkInstagram", "linkLinkedin", "textCopyright", "color1", "color2", "color3", "color4", "color5", "color6", "color7", "color8", "color9", "color10", "color11", "color12", "color13", "color14", "color15", "color16", "color17", "color18", "color19", "color20", "color21", "color22", "userId"];
    protected $useTimestamps = true;

    public function getSetting($id = false)
    {
        if ($id == false) {
            return $this->findAll();
        }
        return $this->select("user.username,setting.*")->join('user', 'user.id = setting.userId')->where(['setting.id' => $id])->first();
    }
}
