<?php
require_once('tfpdf.php');

/*according to the grammar of fpdf set some pdf's style
 *
 * */

class Limefpdf extends tFPDF
{

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 10, $this->PageNo(), 0, 0, 'C');
    }

    private function tableStyle($style) {
        $baseStyle = [
            // 'ko' => [
            //     'width' => 0,
            // ],
            'ko' => [],
            'td' => [
                'width' => 20,
                'height' => 20,
                'border' => '',
                'font' => 'SHS',
                'fontSize' => 14,
                'color' => '160,160,160',
            ],
        ];

        return array_merge($baseStyle, $style);
    }

    /* 
     * 生成表格样式，适用于表格中每个单元格都为单行的情况，支持缩进不支持图片
     *
     * @$data 数据数组，按照表格的实际位置来设置。
     * 示例如下：
    $data = [
        ['周一', '周二', '周三', '周四'],
        ['性别：', '女', '籍贯：', '湖北'],
        ['婚姻：', '已婚', '信仰：', '无'],
    ];
     *
     * @$classArray 样式class数组，按照表格的实际位置来设置。
     * 如果$data为动态生成表格行数的，则需要class数组至少有2行，第三行为一个'repeat'字符串使下面的行都使用第二行的class。
     * 示例如下：
    $class = [
        ['th', 'th', 'th','th'],
        ['tt', 'td', 'tt', 'td'],
        'repeat',
    ];
     *
     * $styleArray 参考tableStyle函数
     */
    public function singleLineTable($data, $classArray, $styleArray) {
        $styleArray = $this->tableStyle($styleArray);
        
        $repeatRow = false;
        if(isset($classArray[2]) && $classArray[2] == 'repeat') {
            $repeatRow = true;
        }

        foreach($data as $r => $row) {
            $res = 1; //第一个插入空白

            foreach($row as $c => $value) {
                $class = $repeatRow && $r > 1 ? $classArray[1][$c] : $classArray[$r][$c];

                // 第一列
                if($res == 1) {
                    // 空单元格
                    if(isset($styleArray['ko'])&& !empty($styleArray['ko'])) {
                        $this->Cell($styleArray['ko']['width'], $styleArray[$class]['height']);
                    }
                    $res = 0;
                }

                // 字体颜色
                $this->SetTextColor($styleArray[$class]['color']);
                
                // 字体
                $this->SetFont($styleArray[$class]['font'], '', $styleArray[$class]['fontSize']);

                // 边框
                $border = $styleArray[$class]['border'] == 1 ? 1 : 0;
                $this->Cell($styleArray[$class]['width'], $styleArray[$class]['height'], $value, $border);
            }
            $this->Ln();
            
        }
    }

    // 生成表格样式，适用于表格中每个单元格为有限行的情况（不支持将长字符串自动转为多行），支持缩进不支持图片
    // style的格式参考tableStyle函数
    // data的格式为
    // [
    //     [
    //         [
    //             'class' => 'tt',
    //             'value' => ['早餐'],
    //         ],
    //         [
    //             'class' => 'td',
    //             'value' => ['杂粮豆浆', '玉米饼', '自制小菜'],
    //         ],
    //         [
    //             'class' => 'td',
    //             'value' => ['五彩虾仁', '冬瓜老鸭汤', '红豆米饭', '红薯'],
    //         ],
    //     ],
    //     [
    //         [
    //             'class' => 'tt',
    //             'value' => ['上午茶歇'],
    //         ],
    //         [
    //             'class' => 'td',
    //             'value' => ['时令水果'],
    //         ],
    //         [
    //             'class' => 'td',
    //             'value' => ['时令水果'],
    //         ],
    //     ],
    // ]
    public function multiLineTable($data, $style) {
        $style = $this->tableStyle($style);
        $trStyle = $style['tr'];
        foreach($data as $row) {

            // 算表格内一行中出现的最大的行数
            $rowCount = 1;
            foreach($row as $cell) {
                $count = count($cell['value']);
                if($count > $rowCount) {
                    $rowCount = $count;
                }
            }

            for($i=0; $i<$rowCount; $i++) {

                $res = 1; //第一个插入空白
                foreach($row as $cell) {
                    $class = $cell['class'];
                    $values = $cell['value'];
                    $value = isset($values[$i]) ? $values[$i] : '';

                    // 第一列
                    if($res == 1) {
                        // 空单元格
                        if(isset($style['ko'])&& !empty($style['ko'])) {
                            $this->Cell($style['ko']['width'], $trStyle['height']);
                        }
                        $res = 0;
                    }

                    // 字体颜色
                    $this->SetTextColor($style[$class]['color']);
                    
                    // 字体
                    $this->SetFont($style[$class]['font'], '', $style[$class]['fontSize']);

                    // 边框
                    $border = $trStyle['border'] == 1 ? 1 : 0;
                    if($border == 1 && $rowCount > 1) { // 只有一行时底下的规则都不适用
                        if($i == 0) { // 第一行是上左右有边框
                            $border = 'TLR';
                        } elseif($i == $rowCount - 1) { // 最后一行是下左右有边框
                            $border = 'BLR';
                        } else { // 中间行是左右有边框
                            $border = 'LR';
                        }
                    }
                    $background=false;
                    if(isset($style[$class]['background'])&&!empty($style[$class]['background']))
                    {
                        $background=true;
                        $this->SetFillColor($style[$class]['background']);
                    }

                    $this->Cell($style[$class]['width'], $trStyle['height'], $value, $border,0,'L',$background);
                }
                $this->Ln();

            }


            
        }
    }


    // 多行列表的控件，适用于列表名为单行值为多行的情况，支持缩进河图片
    // style的格式参考tableStyle函数
    // data的格式为
    // [
    //     [
    //         [
    //             'class' => 'tt',
    //             'value' => '姓名：',
    //         ],
    //         [
    //             'class' => 'td',
    //             'value' => $base['姓名'],
    //         ],
    //     ],
    //     [
    //         [
    //             'class' => 'tt',
    //             'value' => '工号：',
    //         ],
    //         [
    //             'class' => 'td',
    //             'value' => $base['员工编号'],
    //         ],
    //     ],
    // ]
    
    public function multiLineList($data, $style, $images) {
        $style = $this->tableStyle($style);
        $trStyle = $style['tr'];
        $k = 0; // 统计data行数
        foreach($data as $j => $row) {
            $res = 1; // 第一个插入空白

            foreach($row as $k => $cell) {
                $class = $cell['class'];
                $value = $cell['value'];

                // 第一列
                if($res == 1) {
                    // 空单元格
                    if(isset($style['ko'])&& !empty($style['ko'])) {
                        $this->Cell($style['ko']['width'], $trStyle['height']);
                    }
                    
                    // 第一列左侧插入图片
                    if(isset($images) && !empty($images['value'][$j])) {
                        $x = $this->GetX();
                        $y = $this->GetY();
                        $this->Image($images['value'][$j], $x+$images['style']['l'], $y+$images['style']['t'], $images['style']['w'], $images['style']['h']);
                    }

                    $res = 0;
                }

                // 字体颜色
                $this->SetTextColor($style[$class]['color']);

                // 字体
                $this->SetFont($style[$class]['font'], '', $style[$class]['fontSize']);
                
                // 最后一列要用MultiCell
                if($k+1 == count($row)) {

                    $this->MultiCell($style[$class]['width'], $trStyle['height'], $value);
                } else {
                    $this->Cell($style[$class]['width'], $trStyle['height'], $value);
                }
            }
            
        }
    } 

/*
$servedata=[
'data'=>$retarray['工作经历'],
'L'=>
    [ '服务开始时间','服务结束时间'],  左侧所需的时间内容
'R'=> [
    'images'=>['images/interview/0001.png',  //右侧图片
                'images/interview/0002.png',
                'images/interview/0003.png',],
    'title'=>['服务对象','工作内容','客户评价'],  //右侧标题
    'value'=>['服务对象基本情况','工作内容','客户或家属评价'], //标题对应的内容
],];
$servestyle=[
'L'=>['w' => 60,   左侧样式
       'h'=>10,
    'font' => 'SHS',
    'fontSize' => 13,
    'color'=>'',],
'R'=>[              右侧样式
'images'=>['w'=>8,
            'h'=>8,],
'title'=>['w' => 110,
            'h'=>10,
            'font' => 'SHS',
            'fontSize' => 13,
            'color'=>'0,0,0',],
'value'=>['w' => 110,
            'h'=>10,
            'font' => 'SHS',
            'fontSize' => 13,
            'color'=>'190,190,190',],
],

];*/
    public static function LORM($pdf, $data, $style)
    {
        $L=$data['L'];
        $R=$data['R'];
        $data=$data['data'];
        $LS=$style['L'];
        foreach ($data as $work) {
            $pdf->Ln();
            $pdf -> SetFont ($LS['font'], '', $LS['fontSize']);
            $l = $work[$L[0]];
            $pdf->Cell($LS['w'], $LS['h'], $l);
            for($i=0;$i<count($R['value']);$i++)
            {
                if(!empty($work[$R['value'][$i]])) {
                    static:: LORM_R($pdf,$work,$R,$i,$style);
                }
            }

        }
    }

    public static function LORM_R($pdf,$work,$R,$i,$style)
    {

        $LS=$style['L'];
        $RS=$style['R'];

        if($i!=0)
        {
            $pdf->Cell($LS['w'], $LS['h']);
        }
        $x=$pdf->getX();
        $y=$pdf->getY();
        $pdf->image($R['images'][$i],$x-10,$y+2,$RS['images']['w'],$RS['images']['h']);

        if(!empty($R['line'])) {
            $l = $RS['line']['l'];
            $t = $RS['line']['t'];
            $w = $RS['line']['w'];
            $h = $RS['line']['h'];
            $pdf->image($R['line'], $x+$l, $y+$t, $w, $h);
        }

        $pdf->SetTextColor($RS['title']['color']);
        $pdf -> SetFont ($RS['title']['font'], '', $RS['title']['fontSize']);
        $pdf->Cell($RS['title']['w'], $RS['title']['h'], $R['title'][$i].'', '');
        $pdf->Ln();
        $pdf->Cell($LS['w'], $LS['h']);
        $pdf -> SetFont ($RS['value']['font'], '', $RS['value']['fontSize']);
        $pdf->SetTextColor($RS['value']['color']);
        $pdf->MultiCell($RS['value']['w'], $RS['value']['h'], $work[$R['value'][$i]]);
        $pdf->Ln(5);
        $pdf->SetTextColor(0,0,0);
    }


/*
$workdata=[
'data'=>$retarray['以往经历'],
'L'=>
    [ '开始时间','结束时间'],  左侧所需的时间内容
'R'=> [
    'images'=>'images/interview/0001.png',  //右侧图片
    'value'=>['工作单位','职务'],          //右侧内容
    ],];
$workstyle=[
'L'=>['w' => 40,    //坐厕样式
        'h'=>8,
        'font' => 'SHS',
        'fontSize' => 13,
        'color'=>'',],
'R'=>[              //右侧样式
    'images'=>['w'=>8,
    'h'=>8,],
    'value'=>[
    ['w' => 90, 'h'=>8,'font' => 'SHS',
    'fontSize' => 13,
    ],
    ['w' => 50, 'h'=>8,'font' => 'SHS',
    'fontSize' => 13,
    ],
    ],
],

];*/
    public static function LORO($pdf, $data, $style)
    {
        $LS=$style['L'];
        $RS=$style['R'];
        $R=$data['R'];
        foreach ($data['data'] as $experience)
        {
            $pdf->Ln();
            $pdf -> SetFont ($LS['font'], '', $LS['fontSize']);
            $pdf->SetTextColor($LS['color']);
            $pdf->Cell($LS['w'], $LS['h'], $experience[$data['L'][0]]);
            if(isset($R['images']) &&!empty($R['images']))
            {
                $x=$pdf->getX();
                $y=$pdf->getY();
                $l=$RS['images']['l'];
                $t=$RS['images']['t'];
                $pdf->image($R['images'],$x+$l,$y+$t,$RS['images']['w'],$RS['images']['h']);
            }

            if(!empty($R['line'])) {
                $l = $RS['line']['l'];
                $t = $RS['line']['t'];
                $w = $RS['line']['w'];
                $h = $RS['line']['h'];
                $pdf->image($R['line'], $x+$l, $y+$t, $w, $h);
            }

            $pdf -> SetFont ($RS['value'][0]['font'], '', $RS['value'][0]['fontSize']);
            //右侧内容
            for($i=0;$i<count($data['R']['value']);$i++)
            {   $pdf -> SetFont ($RS['value'][$i]['font'], '', $RS['value'][$i]['fontSize']);
                $job=$experience[$data['R']['value'][$i]];
                $pdf->SetTextColor($RS['value'][$i]['color']);
                $pdf->Cell($RS['value'][$i]['w'],$RS['value'][$i]['h'], $job, '');
                
            }
        }
    }

    /*$assaimdata=['title'=>'注意事项',
                    'data'=>$arr['noticegoal']->NOTES];
    $assaimstyle=[
        'title'=>[         //头的样式
                'ko'=>'',
                'w' => 210,
                'h'=>10,
                'font' => 'SHS',
                'fontSize' => 14,
                ],
        'content'=>[        //内容的样式
                'ko'=>'5',
                'w' => 170,
                'h'=>10,
                'font' => 'SHS',
                'fontSize' => 13,
                ]
    ];*/
    //数据库中带num的字符串转化成pdf格式
    public static function string2cell($pdf, $data, $style)
    {
        $pdf->SetFont($style['title']['font'], '', $style['title']['fontSize']);

        if (!empty($style['title']['ko'])) {
            $pdf->Cell($style['title']['ko'], 10);
        }
        //表头
        if(isset($data['titleimages'])&& !empty($data['titleimages']))
        {
            static::set_title_img($pdf,$data['titleimages']);
        }
        //判断空是显示 暂无...
        $pdf->Cell($style['title']['w'], 
            $style['title']['h'], 
            $data['title'].$e = !empty($data['data']) ? '' : '             暂无'.$data['title']
        );
        if (!empty($data['data'])) {
            $pdf->SetFont($style['content']['font'], '', $style['content']['fontSize']);
            $noarr =$data['R']['content'];
            $i=0;
            foreach ($noarr as $k => $v) {
                if (!empty($v)) {
                    if (!empty($style['content']['ko'])&& $i!=0) {
                        $pdf->Cell($style['content']['ko'], 10);
                    }
                    $pdf->MultiCell($style['content']['w'], $style['content']['h'], $v);
                }
                $i++;
            }
        }
    }


    /*$menudata=
        ['ftitle'=>'菜谱推荐',  //大标题
        'stitle'=>'week',     //二级标题的值
        'data'=>json_decode($arr['menuplan']->MENU_PLAN,TRUE), //总数据
        'key'=>['早餐','上午茶歇','午餐','下午茶歇','晚餐'],  //需要展示数据标题
        'value'=>['breakfast','amtea','lunch','pmtea','dinner'],  //需要展示数据内容
        ];
    $menustyle=
        [
        'ftitle'=>[
            'ko'=>'',
            'w' => 210,
            'h'=>10,
            'font' => 'SHS',
            'fontSize' => 14,
            ],
        'stitle'=>[
            'ko'=>5,
            'w' => 210,
            'h'=>10,
            'font' => 'SHS',
            'fontSize' => 14,
        ],
        'content'=>[
            'ko'=>8,
            'w' => 180,
            'h'=>10,
            'font' => 'SHS',
            'fontSize' => 13,
        ]
    ];*/
    public static function meau2cell($pdf, $data, $style)
    {
        $pdf->SetFont($style['ftitle']['font'], '', $style['ftitle']['fontSize']);
        $pdf->MultiCell(
            $style['ftitle']['w'], 
            $style['ftitle']['h'], 
            $data['ftitle'].$e = empty($data['data']) ? '暂无'.$data['ftitle'] : '');
        if (!empty($data['data']) && is_array($data['data'])) {
            foreach ($data['data'] as $mk => $mv) {
                $pdf->Cell($style['stitle']['ko'], 10);
                $pdf->SetFont($style['stitle']['font'], '', $style['stitle']['fontSize']);
                $pdf->MultiCell($style['stitle']['w'], $style['stitle']['h'], $mv[$data['stitle']]);
                $pdf->SetFont($style['content']['font'], '', $style['content']['fontSize']);
                for ($i = 0; $i < count($data['key']); $i++) {
                    $pdf->Cell($style['content']['ko'], 10);
                    $pdf->MultiCell(
                        $style['content']['w'], 
                        $style['content']['h'], 
                        $data['key'][$i].'：'.$e = static::renderMenuItems($mv[$data['value'][$i]])
                    );
                }
            }
        }
    }

    public static function renderMenuItems($items = array())
    {
        $content = '';
        if (is_array($items)) {
            foreach ($items as $k => $v) {
                $items[$k] = htmlspecialchars($v);
            }
            $content .= implode(',', $items);
        }
        return $content;
    }


    public static function schdu2cell($pdf, $data, $style)
    {
//        $pdf->SetFont($style['ftitle']['font'], '', $style['ftitle']['fontSize']);
//        $pdf->MultiCell($style['ftitle']['w'], $style['ftitle']['h'], static::TU($data['ftitle'] . $e = !empty($data['data']) ? '' : '暂无' . $data['ftitle']));
//        if (!empty($data['data']) && is_array($data['data'])) {
            $i=0;
            foreach ($data['data'] as $k => $v) {
                $pdf->SetFont($style['stitle']['font'], '', $style['stitle']['fontSize']);
                if($style['content']['ko']!='')
                {
                    $pdf->Cell($style['content']['ko'], 10);
                }
                static::set_title_img($pdf,$data['images']);
                $pdf->MultiCell($style['stitle']['w'], $style['stitle']['h'], $data['stitle'][$i]);
                $i++;
                $pdf->SetFont($style['content']['font'], '', $style['content']['fontSize']);
                if (is_array($v[$data['content']])) {
                    $a = 0;
                    foreach ($v[$data['content']] as $wk => $wv) {
                        $careContent = explode(',', $wv);
                        if (is_array($careContent)) {
                            foreach ($careContent as $ck => $cv) {
                                if($style['content']['ko']!='')
                                {
                                    $pdf->Cell($style['content']['ko'], 10);
                                }

                                $pdf->Cell($style['content']['w'], $style['content']['h'], $cv);
                                $a++;
                                if ($a % $data['num'] == 0) {
                                    $pdf->Ln();
                                }
                            }
                        }
                    }
                    if ($a % $data['num'] != 0) {
                        $pdf->Ln();
                    }
                }

            }
//        }


    }

    public static function set_title_img($pdf,$file)
    {
        $x=$pdf->getX();
        $y=$pdf->getY();
        $pdf->image($file,$x-4,$y+0.5);
    }



}