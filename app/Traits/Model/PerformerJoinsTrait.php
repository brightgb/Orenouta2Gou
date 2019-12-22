<?php
namespace App\Traits\Model;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait PerformerJoinsTrait {
    private $performerJoinQuery = null;

    private function readyForPerformerJoins() {
        if (is_null($this->performerJoinQuery)) {
            $this->performerJoinQuery = $this;
        }
    }

    private function leftJoinPerformers() {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'performers'
            , $this->getTable() . '.performer_id'
            , 'performers.id'
        );
        return $this;
    }
    
    private function leftJoinPerformerProfiles() {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'performer_profiles'
            , $this->getTable() . '.performer_id'
            , 'performer_profiles.performer_id'
        );
        return $this;
    }

    private function leftJoinPerformerInfos() {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'performer_infos'
            , $this->getTable() . '.performer_id'
            , 'performer_infos.performer_id'
        );
        return $this;
    }

    private function leftJoinPerformerProfileImgs() {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'performer_profile_imgs'
            , function ($join) {
                $join->on($this->getTable() . '.performer_id', 'performer_profile_imgs.performer_id');
                $join->where('performer_profile_imgs.img_stat', config('constKey.IMG_STAT.RELEASE'));
                $join->where('performer_profile_imgs.prof_top_flg', 1);
            }
        );
        return $this;
    }

    private function leftJoinPerformerFavoritesPerformer($member_id) {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'performer_favorites'
            , function($join) use ($member_id){
                $join->on($this->getTable() . '.performer_id', 'performer_favorites.performer_id');
                $join->where('performer_favorites.member_id', $member_id);
            }
        );
        return $this;
    }

    private function leftJoinMemberFavoritesPerformer($member_id) {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'member_favorites'
            , function($join) use ($member_id) {
                $join->on($this->getTable() . '.performer_id', 'member_favorites.performer_id');
                $join->where('member_favorites.member_id', $member_id);
            }
        );
        return $this;
    }

    private function leftJoinCallWaitingsPerformer() {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'call_waitings'
            , function($join) {
                $join->on($this->getTable() . '.performer_id', 'call_waitings.user_id');
                $join->where('call_waitings.gender', config('constKey.GENDER.PERFORMER'));
                $join->where('call_waitings.waiting_start_date', '<=', Carbon::now());
                $join->where('call_waitings.waiting_end_date', '>=', Carbon::now());
            }
        );
        return $this;
    }

    private function leftJoinLastInteractionsPerformer($member_id) {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'last_interactions'
            , function($join) use ($member_id) {
                $join->on($this->getTable() . '.performer_id', 'last_interactions.performer_id');
                $join->where('last_interactions.member_id', $member_id);
            }
        );
        return $this;
    }

    private function leftJoinPerformerBlocks($member_id) {
        $this->readyForPerformerJoins();
        $this->performerJoinQuery = $this->performerJoinQuery->leftJoin(
            'performer_blocks'
            , function($join) use ($member_id) {
                $join->on($this->getTable() . '.performer_id', 'performer_blocks.performer_id');
                $join->where('performer_blocks.member_id', $member_id);
            }
        );
        return $this;
    }
}

