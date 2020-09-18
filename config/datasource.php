<?php
return [

    // 'collections' => [
    //     [
    //         'connection' => 'mysql',
    //         'database' => 'dblibrary_v2',
    //         'table' => 'documents',
    //         'select' => [
    //             'documents.id'
    //             ,'documents.name'
    //             ,'documents.description'
    //             ,'documents.gallery_id'
    //             ,'documents.attributes_type'
    //             ,'documents.category'
    //             ,'documents.filename'
    //             ,'documents.fileformat'
    //             ,'documents.filesize'
    //             ,'documents.updated_at'
    //             ,'case when lower(documents.attributes_type) is null then "document" else  lower(documents.attributes_type) end as icon'
    //             ,'"mysql" as source'
    //         ]
    //     ]
    //     ,[
    //         'connection' => 'mysql2',
    //         'database' => 'dblibrary',
    //         'table' => 'documents',
    //         'select' => [
    //             'documents.id'
    //             ,'documents.name'
    //             ,'documents.description'
    //             ,'documents.gallery_id'
    //             ,'documents.attributes_type'
    //             ,'documents.category'
    //             ,'documents.filename'
    //             ,'documents.fileformat'
    //             ,'documents.filesize'
    //             ,'documents.updated_at'
    //             ,'case when lower(documents.attributes_type) is null then "document" else  lower(documents.attributes_type) end as icon'
    //             ,'"mysql" as source'
    //         ]
    //     ]
    // ],

    'collections' => [
        [
            'id' => 'CN1',
            'connection' => 'mysql',
            'database' => 'dblibrary_v2',
            'table' => 'documents',
            'field_id' => 'id',
            'select' => 
                'CONCAT("CN1|",id) as id
                ,id as origin_id
                ,name
                ,description
                ,gallery_id
                ,case when attributes_type is null then "Document" else attributes_type end as attributes_type
                ,category
                ,filename
                ,fileformat
                ,filesize
                ,updated_at
                ,created_at
                ,case when lower(attributes_type) is null then "document" else  lower(attributes_type) end as icon
                ,(select name from galleries where id=gallery_id) as gallery_name
                ,CONCAT(gallery_id,"/",filename) as filepath'
        ]
        ,[
            'id' => 'CN2',
            'connection' => 'mysql2',
            'database' => 'dblibrary',
            'table' => 'documents',
            'field_id' => 'id',
            'select' => 
                'CONCAT("CN2|",id) as id
                ,id as origin_id
                ,name
                ,description
                ,null as gallery_id
                ,case when attributes_type is null then "Document" else attributes_type end as attributes_type
                ,category
                ,filename
                ,fileformat
                ,filesize
                ,updated_at
                ,created_at
                ,case when lower(attributes_type) is null then "document" else  lower(attributes_type) end as icon
                ,null as gallery_name
                ,CONCAT(gallery_id,"/",filename) as filepath'
        ]
    ],
];
