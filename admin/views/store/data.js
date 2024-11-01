import Api from '@/utils/fetchWP'

const defaultState = {
  gcsAuthValidation : 'notready',
  awsAuthValidation : 'notready',
  doAuthValidation : 'notready',
  w2cloudGetGeneralSettings : {"active_storage":"none","serve_from_bucket":false,"up_on_bucket":false,"delete_from_bucket":false, "erase_from_local":false},
  getReadyChannels: []
};

const actions = {
    gcsAuth: (context, {data, bucket}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (data) queryString += `data=${data}`;
        if (bucket) queryString += `&bucket=${bucket}`;

        let response = Api().post(`gcsAuth&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
                return error;
            });
        return response;
      }
      else {
        let queryString = ``;
        if (data) queryString += `data=${data}`;
        if (bucket) queryString += `&bucket=${bucket}`;

        let response = Api().post(`gcsAuth?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
                return error;
            });
        return response;
      }
    },

    gcsAuthValidation: (context) => {
      let response = Api().get('gcsAuthValidation')
            .then(r => {
                context.commit("GCSAUTHVALIDATION", r.data);
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },

    awsAuth: (context, {aws_client_id, aws_client_secret, aws_bucket, aws_region}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (aws_client_id) queryString += `aws_client_id=${aws_client_id}`;
        if (aws_client_secret) queryString += `&aws_client_secret=${aws_client_secret}`;
        if (aws_bucket) queryString += `&aws_bucket=${aws_bucket}`;
        if (aws_region) queryString += `&aws_region=${aws_region}`;

        let response = Api().post(`awsAuth&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
                return error;
            });
        return response;
      }
      else {
        let queryString = ``;
        if (aws_client_id) queryString += `aws_client_id=${aws_client_id}`;
        if (aws_client_secret) queryString += `&aws_client_secret=${aws_client_secret}`;
        if (aws_bucket) queryString += `&aws_bucket=${aws_bucket}`;
        if (aws_region) queryString += `&aws_region=${aws_region}`;

        let response = Api().post(`awsAuth?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
                return error;
            });
        return response;
      }
    },

    doAuth: (context, {do_client_id, do_client_secret, do_bucket, do_region}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (do_client_id) queryString += `do_client_id=${do_client_id}`;
        if (do_client_secret) queryString += `&do_client_secret=${do_client_secret}`;
        if (do_bucket) queryString += `&do_bucket=${do_bucket}`;
        if (do_region) queryString += `&do_region=${do_region}`;

        let response = Api().post(`doAuth&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
                return error;
            });
        return response;
      }
      else {
        let queryString = ``;
        if (do_client_id) queryString += `do_client_id=${do_client_id}`;
        if (do_client_secret) queryString += `&do_client_secret=${do_client_secret}`;
        if (do_bucket) queryString += `&do_bucket=${do_bucket}`;
        if (do_region) queryString += `&do_region=${do_region}`;

        let response = Api().post(`doAuth?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
                return error;
            });
        return response;
      }
    },

    awsAuthValidation: (context) => {
      let response = Api().get('awsAuthValidation')
            .then(r => {
                context.commit("AWSAUTHVALIDATION", r.data);
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },

    doAuthValidation: (context) => {
      let response = Api().get('doAuthValidation')
            .then(r => {
                context.commit("DOAUTHVALIDATION", r.data);
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },

    // getGcsAuthData: (context) => {
    //   let response = Api().get('getGcsAuthData')
    //         .then(r => {
    //             return r.data
    //         })
    //         .catch((error) => {
    //             console.error(error);
    //         });
    //         return response;
    // },

    getGcsAuthData: (context, {type}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (type) queryString += `type=${type}`;
        let response = Api().get(`getGcsAuthData&${queryString}`)
              .then(r => {
                  return r.data
              })
              .catch((error) => {
                  console.error(error);
              });
              return response;
      }
      else {
        let queryString = ``;
        if (type) queryString += `type=${type}`;
        let response = Api().get(`getGcsAuthData?${queryString}`)
              .then(r => {
                  return r.data
              })
              .catch((error) => {
                  console.error(error);
              });
              return response;
      }
    },

    processMediaTransfer: (context, {id}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (id) queryString += `id=${id}`;

        let response = Api().post(`processMediaTransfer&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
      else {
        let queryString = ``;
        if (id) queryString += `id=${id}`;

        let response = Api().post(`processMediaTransfer?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
    },

    processAWSMediaTransfer: (context, {id}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (id) queryString += `id=${id}`;

        let response = Api().post(`processAWSMediaTransfer&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
      else {
        let queryString = ``;
        if (id) queryString += `id=${id}`;

        let response = Api().post(`processAWSMediaTransfer?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
    },

    processDOMediaTransfer: (context, {id}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (id) queryString += `id=${id}`;

        let response = Api().post(`processDOMediaTransfer&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
      else {
        let queryString = ``;
        if (id) queryString += `id=${id}`;

        let response = Api().post(`processDOMediaTransfer?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
    },

    w2cloudPluginRating: (context) => {
      let response = Api().get('w2cloudPluginRating')
            .then(r => {
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },

    w2cloudPluginCompatibility: (context) => {
      let response = Api().get('w2cloudPluginCompatibility')
            .then(r => {
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },

    w2cloudSubmitGeneralSettings: (context, {settings}) => {
      if (window.w2cloud_obj.permalink_structure == "") {
        let queryString = ``;
        if (settings) queryString += `settings=${settings}`;

        let response = Api().post(`w2cloudSubmitGeneralSettings&${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
      else {
        let queryString = ``;
        if (settings) queryString += `settings=${settings}`;

        let response = Api().post(`w2cloudSubmitGeneralSettings?${queryString}`)
            .then(r => {
                return r.data;
            })
            .catch((error) => {
              return 'error';
            });
        return response;
      }
    },

    w2cloudGetGeneralSettings: (context) => {
      let response = Api().get('w2cloudGetGeneralSettings')
            .then(r => {
                context.commit("WCLOUDGETGENERALSETTINGS", r.data);
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },

    getReadyChannels: (context) => {
      let response = Api().get('getReadyChannels')
            .then(r => {
                context.commit("GETREADYCHANNELS", r.data);
                return r.data
            })
            .catch((error) => {
                console.error(error);
            });
            return response;
    },
};

const mutations = {
  GCSAUTHVALIDATION: (state, gcsAuthValidation) => {
        state.gcsAuthValidation = gcsAuthValidation.message;
  },
  GCSAUTHEDIT: (state, gcsAuthValidation) => {
        state.gcsAuthValidation = gcsAuthValidation.status;
  },
  AWSAUTHVALIDATION: (state, awsAuthValidation) => {
        state.awsAuthValidation = awsAuthValidation.message;
  },
  AWSAUTHEDIT: (state, awsAuthValidation) => {
        state.awsAuthValidation = awsAuthValidation.status;
  },
  DOAUTHVALIDATION: (state, doAuthValidation) => {
        state.doAuthValidation = doAuthValidation.message;
  },
  DOAUTHEDIT: (state, doAuthValidation) => {
        state.doAuthValidation = doAuthValidation.status;
  },
  WCLOUDGETGENERALSETTINGS: (state, w2cloudGetGeneralSettings) => {
        state.w2cloudGetGeneralSettings = w2cloudGetGeneralSettings;
  },
  GETREADYCHANNELS: (state, getReadyChannels) => {
        state.getReadyChannels = getReadyChannels;
  },
};

const getters = {
  gcsAuthValidation: state => state.gcsAuthValidation,
  awsAuthValidation: state => state.awsAuthValidation,
  doAuthValidation: state => state.doAuthValidation,
  w2cloudGetGeneralSettings: state => state.w2cloudGetGeneralSettings,
  getReadyChannels: state => state.getReadyChannels,
};

const namespaced = true;

export default {
    namespaced,
    state: defaultState,
    getters,
    actions,
    mutations,
};
