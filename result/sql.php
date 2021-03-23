<?php 
$tblpblntukalo = "

    (
        SELECT COUNT(*) 
        FROM queue f 
        WHERE f.place=queue.place 
        AND f.eventId=queue.eventId
        AND f.queueTime<queue.queueTime
    ) != 0
    OR
    (
        SELECT COUNT(*) 
        FROM tickets
        WHERE queue.place = tickets.place
        AND queue.eventId = tickets.eventId
        AND 
        (
            (
                orderId IS NOT NULL
                AND
                (
                    SELECT COUNT(*) 
                    FROM orders 
                    WHERE orders.orderId = tickets.orderId 
                    AND orders.status LIKE 'canceled%'
                ) = 0
            ) 
            OR 
            (
                clickTime IS NOT NULL 
                AND UNIX_TIMESTAMP(NOW())-UNIX_TIMESTAMP(clickTime)<1200
            )
        )
    ) != 0 

"; 
$sql = "

    SELECT pr.priority,pos.position,pre.priority AS dealPriority,
    result.eventId,result.orderId,result.name,result.place,result.phone,result.firstClick,
    `events`.eventName,`events`.eventDate,
    clients.name,clients.note,
    notes.note AS currentNote FROM
    (
        SELECT queue.eventId, NULL AS orderId, NULL AS name, queue.place, queue.phone, firstClicks.firstClick
        FROM queue 
        LEFT JOIN 
        (
            SELECT phone, MIN(queueTime) AS firstClick 
            FROM queue
            GROUP BY phone
        ) AS firstClicks
        ON firstClicks.phone=queue.phone
        UNION ALL
        SELECT orders.eventId, orders.orderId, orders.name, tickets.place, orders.phone, orders.orderTime
        FROM orders LEFT JOIN tickets ON orders.orderId=tickets.orderId  
    ) result
    LEFT JOIN 
    (
        SELECT result.phone, min(position) AS priority FROM
        (
            SELECT queue.phone, IF (($tblpblntukalo), 2, 1) AS position
            FROM queue 
            UNION ALL
            SELECT orders.phone, 0 AS position FROM orders  
        ) result
        GROUP BY result.phone
    ) pr ON pr.phone=result.phone
    LEFT JOIN 
    (
        SELECT result.eventId, result.phone, min(position) AS priority FROM
        (
            SELECT queue.eventId, queue.phone, IF (($tblpblntukalo), 2, 1) AS position
            FROM queue 
            UNION ALL
            SELECT orders.eventId, orders.phone, 0 AS position FROM orders  
        ) result
        GROUP BY result.phone, result.eventId
    ) pre ON pre.phone=result.phone AND pre.eventId=result.eventId
    LEFT JOIN 
    (
        SELECT result.place, result.eventId, result.phone, position FROM
        (            
            SELECT queue.eventId, queue.place, queue.phone, IF (($tblpblntukalo), 2, 1) AS position
            FROM queue 
            UNION ALL
            SELECT orders.eventId, tickets.place, orders.phone, 0 AS position 
            FROM orders 
            LEFT JOIN tickets ON orders.orderId=tickets.orderId  
        ) result
    ) pos ON pos.phone=result.phone AND pos.eventId = result.eventId AND pos.place = result.place
    LEFT JOIN clients ON clients.phone = result.phone
    LEFT JOIN `events` ON `events`.eventId = result.eventId
    LEFT JOIN notes ON notes.eventId = result.eventId AND notes.phone = result.phone

";