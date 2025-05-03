using LMSService.Application.Services.Concretes;
using LMSService.Application.Services.Interfaces;
using LMSService.Infrastructure.Connectors.Concretes;
using LMSService.Infrastructure.Connectors.Interfaces;
using LMSService.Infrastructure.Repositories.Concretes;
using LMSService.Infrastructure.Repositories.Interfaces;

namespace LMSService.Presentation.Configuration
{
    public static class Configuration
    {
        public static IServiceCollection AddConfiguration(this IServiceCollection services)
        {
            var apiUrl = Environment.GetEnvironmentVariable("CANVAS_API_URL");
            var apiToken = Environment.GetEnvironmentVariable("CANVAS_API_TOKEN");

            if (apiUrl is null || apiToken is null)
            {
                throw new ArgumentNullException(apiUrl is null ? nameof(apiUrl) : nameof(apiToken), "Empty arguments for API connection");
            }

            services.AddScoped<ICourseService, CourseService>();
            services.AddScoped<ICourseRepository, CourseRepository>();

            services.AddHttpClient<ILMSConnector, LMSConector>(
                client =>
                {
                    client.BaseAddress = new Uri(apiUrl);
                    client.DefaultRequestHeaders.Add("Accept", "application/json");
                    client.DefaultRequestHeaders.Add("Authorization", $"Bearer {apiToken}");
                }
            );

            return services;
        }
    }
}
