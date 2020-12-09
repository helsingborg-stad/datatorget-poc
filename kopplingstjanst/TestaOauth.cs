using System;
using System.Collections.Generic;
using System.Text;
using System.Text.Json;
using System.Net;
using System.Threading;
using System.Threading.Tasks;
using System.Diagnostics;
using System.Net.Http;
using IdentityModel.Client;

namespace kopplingstjanst
{
    static class TestaOauth
    {
        public static async Task Run()
        {
            Thread.Sleep(2000);

            var client = new HttpClient();
            var disco = await client.GetDiscoveryDocumentAsync(new DiscoveryDocumentRequest { Address = _Config.OauthAuthority, Policy = { RequireHttps = false } });
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

            //var response = await client.GetAsync(_Config.OauthAuthority + "/authtest");
            //if (!response.IsSuccessStatusCode)
            //{
            //    Debug.WriteLine(response.StatusCode);
            //}
            //else
            //{
            //    var content = await response.Content.ReadAsStringAsync();
            //    Debug.WriteLine(content);
            //}

            var response = await client.PostAsync("http://datatorget2.helsingborg.se:30003/api/v1/epost/skicka?mottagareEpost=datatorget%40helsingborg.se&avsandareEpost=datatorget%40helsingborg.se&amne=test&meddelandetext=test", new StringContent(""));
            if (!response.IsSuccessStatusCode)
            {
                Debug.WriteLine(response.StatusCode);
            }
            else
            {
                Debug.WriteLine("API call succeeded");
            }
        }
    }
}
