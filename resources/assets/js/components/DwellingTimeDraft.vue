<template lang="html">
    <div class="timeline-basic">
		<div class="timeline-entry" v-for="d in dwellingTimes">
			<div class="timeline-circle">&nbsp;</div>
			<div class="timeline-panel">
				<div class="timeline-heading">
					<h2 :class="['timeline-title', 'text-' + colors[d.status]]">
                        {{statuses[d.status]}}
                    </h2>
				</div>
				<div class="timeline-body">
                    Time :{{d.time | readableDate}} {{d.time | readableTime}} <br>
                    Duration : ({{d.duration | readableDuration}})</small>
                    <hr>
					<p>{{d.description}}</p>
				</div>
			</div>
		</div>
	</div>

</template>

<script>
export default {
    name: 'DwellingTime',
    props: ['barging', 'title'],
    data: function() {
        return {
            dwellingTimes: [],
            statuses: ["Initiate", "Loading", "Breakdown", "Delay", "Idle", "Complete"],
            colors: ["info", "success", "danger", "warning", "default", "primary"],
        }
    },
    filters: {
        readableDate: function(v) {
            return moment(v).format('DD-MMM-YYYY');
        },
        readableTime: function(v) {
            return moment(v).format('HH:mm');
        },
        readableDuration(v) {
            if (parseInt(v)) {
                var days = Math.floor(v/(60*24));
                var hours = Math.floor((v%(60*24)) / 60);
                var mins = Math.floor(v%60);
                return days+'d:'+hours+'h:'+mins+'m';
            }

            return '';
        }
    },
    methods: {
        requestData: function() {
            var _this = this;
            var params = {
                barging_id: _this.barging
            };

            axios.get(BASE_URL + '/api/dwellingTime', {params:params})
                .then(function(r) {
                    _this.dwellingTimes = r.data;

                    for (var i in _this.dwellingTimes) {
                        if (_this.dwellingTimes[i].status == 0) {
                            _this.dwellingTimes[i].duration = '-';
                            continue;
                        }

                        var date1 = moment(_this.dwellingTimes[i].time)
                        var date2 = (i == 0) ? moment() : moment(_this.dwellingTimes[i-1].time);
                        var duration = moment.duration(date2.diff(date1));
                        _this.dwellingTimes[i].duration = duration.asMinutes();
                    }

                })
                .catch(function(e) {
                    console.log(e);
                });

            setTimeout(this.requestData, 5000);
        }
    },
    mounted: function() {
        this.requestData();
    }
}
</script>

<style lang="css">
</style>
