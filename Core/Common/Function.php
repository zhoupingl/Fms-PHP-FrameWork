<?php
// 公共函数集.
/**
 * 分割字符串.
 *
 * @param string      $delimiter 分割字符串符号.
 * @param string      $string    被分割字符串.
 * @param null|string $limit     分割字符串返回数据个数据,不够以NULL填充.
 *
 * @return array
 */
function FMS_explode($delimiter = '', $string = '', $limit = NULL)
{
    $args = explode($delimiter, $string, $limit);
    if (is_numeric($limit) && count($args) < $limit) {
        $count = count($args);
        while ($count < $limit) {
            $args[$count] = NULL;
            $count++;
        }
    }

    return $args;
}