<?php
namespace App\Traits\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait MemberJoinsTrait {
    private $memberJoinQuery = null;

    private function readyForMemberJoins() {
        if (is_null($this->memberJoinQuery)) {
            $this->memberJoinQuery = $this;
        }
    }

    private function leftJoinMembers() {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'members'
            , $this->getTable() . '.member_id'
            , 'members.id'
        );
        return $this;
    }
    
    private function leftJoinMemberProfiles() {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'member_profiles'
            , $this->getTable() . '.member_id'
            , 'member_profiles.member_id'
        );
        return $this;
    }

    private function leftJoinMemberInfos() {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'member_infos'
            , $this->getTable() . '.member_id'
            , 'member_infos.member_id'
        );
        return $this;
    }

    private function leftJoinMemberProfileImgs() {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'member_profile_imgs'
            , function ($join) {
                $join->on($this->getTable() . '.member_id', 'member_profile_imgs.member_id');
                $join->where('member_profile_imgs.img_stat', config('constKey.IMG_STAT.RELEASE'));
            }
        );
        return $this;
    }

    private function leftJoinMemberFavoritesMember($performer_id) {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'member_favorites'
            , function($join) use ($performer_id){
                $join->on($this->getTable() . '.member_id', 'member_favorites.member_id');
                $join->where('member_favorites.performer_id', $performer_id);
            }
        );
        return $this;
    }

    private function leftJoinPerformerFavoritesMember($performer_id) {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'performer_favorites'
            , function($join) use ($performer_id) {
                $join->on($this->getTable() . '.member_id', 'performer_favorites.member_id');
                $join->where('performer_favorites.performer_id', $performer_id);
            }
        );
        return $this;
    }

    private function leftJoinCallWaitingsMember() {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'call_waitings'
            , function($join) {
                $join->on($this->getTable() . '.member_id', 'call_waitings.user_id');
                $join->where('call_waitings.gender', config('constKey.GENDER.MEMBER'));
                $join->where('call_waitings.waiting_start_date', '<=', Carbon::now());
                $join->where('call_waitings.waiting_end_date', '>=', Carbon::now());
            }
        );
        return $this;
    }

    private function leftJoinLastInteractionsMember($performer_id) {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'last_interactions'
            , function($join) use ($performer_id) {
                $join->on($this->getTable() . '.member_id', 'last_interactions.member_id');
                $join->where('last_interactions.performer_id', $performer_id);
            }
        );
        return $this;
    }

    private function leftJoinMemberBlocks($performer_id) {
        $this->readyForMemberJoins();
        $this->memberJoinQuery = $this->memberJoinQuery->leftJoin(
            'member_blocks'
            , function($join) use ($performer_id) {
                $join->on($this->getTable() . '.member_id', 'member_blocks.member_id');
                $join->where('member_blocks.performer_id', $performer_id);
            }
        );
        return $this;
    }
}

