<template>
    <tr>
        <th scope="row">{{ lineDetailsLocal.lineNumber }}</th>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.description"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.price"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.hcopy"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyReturned"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.unit"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyInspect"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.qtyReturned"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.goodCondition"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.minorRepairClean"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.repairPartsNeeded"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.damaged"
            />
        </td>
        <td>
            <input
                type="text"
                class="form-control form-control-sm"
                v-model="lineDetailsLocal.comments"
            />
        </td>
        <td>
            <input type="text" class="form-control form-control-sm" />
        </td>
    </tr>
</template>

<script>
export default {
    props: ["lineDetails"],
    data() {
        return {
            lineDetailsLocal: this.lineDetails,
        };
    },
};
</script>

<style></style>
