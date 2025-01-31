# Модуль “Магазин ноутбуков”
Модуль решает проблемы хранения и поиска ноутбуков на сайте интернет-магазина и не обладает каким-либо интерфейсом администрирования (предположим, все данные в него попадают автоматически).
***

## 1. Сущности модуля
Модуль обладает следующими сущностями:
- Производитель (обязательно обладает свойствами id и name);
- Модель (обязательно обладает свойствами id и name);
- Ноутбук (обязательно обладает свойствами id, name, year и price);
- Опция (обязательно обладает свойствами id и name).

Сущности взаимосвязаны следующим образом:
- Каждая модель обязательно привязана к одному производителю;
- Каждый ноутбук обязательно привязан к одной модели;
- Любая опция может быть привязана к любому количеству ноутбуков.

Атрибуты сущностей могут быть расширены до любого количества в целях обеспечения решения задания.
Вся реализация, в том числе сущности и их взаимосвязи,должна быть сделана с использованием `Bitrix ORM`.

## 2. Компоненты
Модуль включает в себя следующий набор компонентов:
- Комплексный компонент;
- Компонент списка;
- Компонент детальной страницы
## 2.1 Комплексный компонент
Комплексный компонент должен работать в режиме ЧПУ и обрабатывать 4 уровня URL:
- `/#SEF_FOLDER#/` - список производителей
- `/#SEF_FOLDER#/#BRAND#/` - список моделей производителя
- `/#SEF_FOLDER#/#BRAND#/#MODEL#/` - список ноутбуков модели
- `/#SEF_FOLDER#/detail/#NOTEBOOK#/` - детальная страница ноутбука
На всех уровнях кроме 4-го должен быть расположен компонент списка, на 4-м - компонент, реализующий детальную страницу конкретного ноутбука.
## 2.2 Компонент списка
Компонент списка должен реализовывать выбор сущности для построения списка (производители, модели, ноутбуки), сортировку (по цене и году выпуска) в 2-х направлениях (по убыванию и по возрастанию), постраничную навигацию (с выбором размера страницы).Весь функционал должен быть доступен через интерфейс пользователя (не через параметры компонента).
## 2.3. Компонент детальной страницы
Компонент детальной страницы должен выводить всю информацию по ноутбуку, включая его производителя, модель и опции конкретного ноутбука, год выпуска и цену.
- **Установка** - Установка модуля должна проходить в 2 шага, на первом шаге должно быть выведено сообщение и чекбокс, предлагающие удалить существующие таблицы и создать их заново.
На втором шаге происходит установка (действия с таблицами, копирование компонентов и файлов и т.п.). Копировать файлы необходимо в пределах `/local/`.
В случае установки вместе с БД необходимо предусмотреть тестовое наполнение для базы данных чтобы проверить работоспособность модуля (т.е. установленный модуль — это не чистая БД и скопированные файлы, а полностью работающее решение с тестовыми производителями, моделями, ноутбуками и т.п.).
- **Удаление** - При удалении модуль должен спросить - удалять ли таблицы или оставить. Соответственно при удалении, в случае необходимости, должны быть удалены таблицы. Компоненты и прочую файловую составляющую не трогаем.
***
## Как проверяется задание
Проверка будет осуществляться следующим образом: мы делаем чистую установку БУС актуальной версии на web-сервер с предустановленным php 8, клонируем репозиторий модуля в папку /local/modules, перетащим компоненты через визуальный редактор на чистую страницу и откроем их настройки.
После первичной настройки комплексного компоненты через интерфейс, мы рассчитываем получить в разделе сайта 4-уровневую структуру и увидеть тестовые данные.
### Уровни выполнения задания
#### Базовый уровень:
1. Предоставлена ссылка на публичный git-репозиторий с готовым решением (BitBucket, GitHub, GitLab).
2. Реализация модуля с 2х шаговой установкой и удалением.
3. Реализация комплексного компонента (с режимом ЧПУ) и компонентов списка и детального просмотра.
4. Реализация хранения и получения данных через ORM.
5. Реализация установки тестовых данных через методы ORM (не чистый sql).
6. Все компоненты должны иметь файлы с параметрами и описанием (`.parameters.php` и `.description.php`).
7. Вывод списка и детальной страницы стилизован с помощью Bootstrap, входящий в комплект Битрикс.
#### Продвинутый уровень:
1. Соблюдение PSR-12.
2. Соответствие принципам проектирования (KISS, DRY и другие).
3. Компонент списка реализован с помощью grid-компонентов Битрикс.
4. Реализация у модуля настроек прав доступа.
5. Использование языковых файлов.