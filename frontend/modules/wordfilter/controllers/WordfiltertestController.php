<?php

namespace frontend\modules\wordfilter\controllers;

use frontend\components\AuthController;
use Yii;
use common\models\oldbk\Wordfilter;
use common\models\oldbk\WordfilterException;
use yii\filters\VerbFilter;

/**
 * WordfilterExceptionController implements the CRUD actions for Wordfilter model
 */
class WordfiltertestController extends AuthController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    static private $charsreplace = [
	 'а' => ['a', '@','o', '0','о'],
	 'б' => ['6', 'b'],
	 'в' => ['b', 'v'],
	 'г' => ['r', 'g'],
	 'д' => ['d', 'g'],
	 'е' => ['e','ё','u','i','й','и','э'],
	 'ё' => ['е','e','u','i','й'],
	 'ж' => ['zh'],
	 'з' => ['3', 'z'],
	 'и' => ['u', 'i','й','e','ё','е'],
	 'й' => ['u', 'y','i','и'],
	 'к' => ['k'],
	 'л' => ['l', 'ji'],
	 'м' => ['m'],
	 'н' => ['h', 'n'],
	 'о' => ['o', '0','a', '@','а'],
	 'п' => ['n', 'p'],
	 'р' => ['r', 'p'],
	 'с' => ['c', 's'],
	 'т' => ['m', 't'],
	 'у' => ['y', 'u'],
	 'ф' => ['f'],
	 'х' => ['x', 'h', 'к', 'k'],
	 'ц' => ['c', 'u,'],
	 'ч' => ['ch'],
	 'ш' => ['sh'],
	 'щ' => ['sch'],
	 'ь' => ['b', 'ъ'],
	 'ы' => ['bi'],
	 'ъ' => ['ь'],
	 'э' => ['е', 'e'],
	 'ю' => ['io'],
	 'я' => ['ya'],
    ];

    /**
     * Lists all WordfilterException models.
     * @return mixed
     */
    public function actionIndex()
    {

	$request = Yii::$app->request;
	$CheckData = $request->post('check', '');
	$result = "";

	if (mb_strlen($CheckData)) {
		$result = $CheckData;
		$words = Wordfilter::find()->all();
	
		$sword = "";

		foreach ($words as $word) {
			// prepare word
			$sword .= "(";

			for ($i = 0; $i < mb_strlen($word['word']); $i++) {
				$char = mb_substr($word['word'],$i,1);
				$sword .= "[".preg_quote($char);

				if (!$word['onlyfull'] && isset(self::$charsreplace[$char])) {
					foreach(self::$charsreplace[$char] as $rpchar) {
						$sword .= $rpchar;
					}
				}
				$sword .= ']';
			}
			$sword .= ')|';
		}

		$sword = mb_substr($sword,0,-1);

		if (mb_strlen($sword)) {

			$wordsex = WordfilterException::find()->andWhere('incsearch = :incsearch', [':incsearch' => 0])->all();
			$wordsex2 = WordfilterException::find()->andWhere('incsearch = :incsearch', [':incsearch' => 1])->all();
			$wordsex3 = Wordfilter::find()->andWhere('onlyfull = :onlyfull', [':onlyfull' => 1])->all();

			$exlist = array();
			$exlist2 = array();

			// только полный поиск
			$exlist3 = array();

			foreach($wordsex as $ex) {
				$exlist[trim($ex['word'])] = 1;
			}

			foreach($wordsex2 as $ex) {
				$exlist2[trim($ex['word'])] = 1;
			}

			foreach($wordsex3 as $ex) {
				$exlist3[trim($ex['word'])] = 1;
			}

			echo $sword;

			$result = preg_replace_callback('/(?:^|\b|\w+)('.$sword.')(?:$|\b|\w+)?/ui',
			//$result = preg_replace_callback('/(?:[^_|(?:^|\b|\w+)])?'.$sword.'(?:[^_|(?:^|\b|\w+)])?/ui',
				function ($m) use ($exlist,$exlist2,$exlist3) {
					print_r($m);
					$countf = 0;
					while(list($k,$v) = each($m)) {
						if (strlen($v)) $countf++;
					}

					if ($countf <= 1) return $m[0];

					if (isset($exlist[mb_strtolower($m[0])])) return $m[0];
	
					$foundinc = false;
					reset($exlist2);
					while(list($k,$v) = each($exlist2)) {
						if (stripos($m[0],$k) !== false) {
							$foundinc = true;
						}
					}

					if ($foundinc) return $m[0];

					if (isset($m[1])) {
						if (isset($exlist3[$m[1]])) {
							if (mb_strtolower($m[0]) != mb_strtolower($m[1])) return $m[0];
						}
					}

					return "***";
					//return str_replace($m[1],"***",$m[0]);
				}
			,$result);
		}
	}

        return $this->render('index', [
            'CheckData' => $CheckData,
            'result' => $result,
        ]);

    }

}
