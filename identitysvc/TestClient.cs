using IdentityModel.Client;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Net.Http;
using System.Threading;
using System.Threading.Tasks;

namespace identitysvc
{
    public class TestClient
    {
        public async Task Run()
        {
            Thread.Sleep(2000);

            var client = new HttpClient();
            var disco = await client.GetDiscoveryDocumentAsync(Config.OauthAuthority);
            if (disco.IsError)
            {
                Debug.WriteLine(disco.Error);
                return;
            }

            var tokenResponse = await client.RequestClientCredentialsTokenAsync(new ClientCredentialsTokenRequest
            {
                Address = disco.TokenEndpoint,

                ClientId = "webui",
                ClientSecret = "secret",
                Scope = "datatorget1"
            });

            if (tokenResponse.IsError)
            {
                Debug.WriteLine(tokenResponse.Error);
                return;
            }

            Debug.WriteLine(tokenResponse.Json);

            client.SetBearerToken(tokenResponse.AccessToken);

            var response = await client.GetAsync(Config.OauthAuthority + "/authtest");
            if (!response.IsSuccessStatusCode)
            {
                Debug.WriteLine(response.StatusCode);
            }
            else
            {
                var content = await response.Content.ReadAsStringAsync();
                Debug.WriteLine(content);
            }
        }
    }
}
