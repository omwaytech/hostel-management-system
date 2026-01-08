<?php

use App\Models\Block;
use App\Models\Floor;
use App\Models\Hostel;
use App\Models\Resident;
/**
 *
 * @param string $type
 * @param string $modelName
 * @param string $action
 * @param string|null $message
 *
 * @return array
 */
function notificationMessage(string $type, string $modelName, string $action, string $message = null): array
{
    $notification = [];

    switch ($type) {
        case 'success':
            $notification = [
                'message' => "{$modelName} {$action} successfully.",
                'alert-type' => 'success',
            ];
            break;

        case 'error':
            $notification = [
                'message' => "{$modelName} could not be {$action}: {$message}",
                'alert-type' => 'error',
            ];
            break;

        case 'warning':
            $notification = [
                'message' => $message,
                'alert-type' => 'warning',
            ];
            break;

        case 'info':
            $notification = [
                'message' => $message,
                'alert-type' => 'info',
            ];
            break;

        default:
            $notification = [
                'message' => 'An unknown notification type was provided.',
                'alert-type' => 'error',
            ];
        break;
    }

    return $notification;
}

function getCurrentHostel()
{
    $hostelId = session('current_hostel_id');

    return $hostelId ? Hostel::find($hostelId) : null;
}

function getCurrentBlock()
{
    $blockId = session('current_block_id');

    return $blockId ? Block::find($blockId) : null;
}

function getFloorsWithRoomsAndBedsByBlocks($blocks)
{
    $result = [];

    foreach ($blocks as $block) {
        $floors = Floor::with(['rooms.beds'])
            ->where('block_id', $block->id)
            ->get();

        $result[] = [
            'block' => $block,
            'floors' => $floors
        ];
    }

    return collect($result);
}

function termsAndPolicies()
{
    $hostel = session('active_hostel');

    $result = [];

    if ($hostel) {
        $terms = $hostel->termsAndPolicies()->where('is_deleted', 0)->get();
    }

    return $terms;
}
